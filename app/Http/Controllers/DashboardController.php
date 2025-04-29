<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Submission;
use App\Models\Organization;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = User::find(Auth::id());

        // Range 30 hari terakhir
        $dates = collect(range(0, 29))->map(function ($i) {
            return Carbon::today()->subDays(29 - $i)->format('Y-m-d');
        });

        // Initialize grafik data
        $pendingData = [];
        $submittedData = [];
        $completedData = [];

        foreach ($dates as $date) {
            // Tugas belum dikerjakan (harus hitung recurring juga)
            $pendingCount = Task::dueOn($date)
                ->where('organization_id', $user->organization_id)
                ->get()
                ->filter(function ($task) use ($user, $date) {
                    return !$task->submissions()
                        ->where('user_id', $user->id)
                        ->whereDate('submitted_at', $date)
                        ->exists();
                })
                ->count();

            $submittedCount = Submission::where('user_id', $user->id)
                ->whereDate('submitted_at', $date)
                ->where('status', 'pending')
                ->count();

            $completedCount = Submission::where('user_id', $user->id)
                ->whereDate('submitted_at', $date)
                ->where('status', 'approved')
                ->count();

            $pendingData[] = $pendingCount;
            $submittedData[] = $submittedCount;
            $completedData[] = $completedCount;
        }

        // Ambil tugas hari ini yang belum dikerjakan
        $tasks = Task::dueUpcoming()
            ->where('organization_id', $user->organization_id)
            ->unsubmittedBy($user->id)
            ->get();

        $submittedTasks = $user->submissions()
            ->pending()
            ->with('task')
            ->get()
            ->pluck('task');

        $completedTasks = $user->submissions()
            ->approved()
            ->with('task')
            ->get()
            ->pluck('task');

        $totalTasks = $tasks->count() + $submittedTasks->count() + $completedTasks->count();
        $completedTasksCount = $completedTasks->count();
        $pendingTasks = $tasks->count();

        return view('dashboard', compact(
            'tasks',
            'submittedTasks',
            'completedTasks',
            'totalTasks',
            'completedTasksCount',
            'pendingTasks',
            'dates',
            'pendingData',
            'submittedData',
            'completedData'
        ));
    }

    public function adminDashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalOrganizations' => Organization::count(),
            'totalTasks' => Task::count(),
            'totalSubmissions' => Submission::count(),
            'recentTasks' => Task::latest()->take(5)->get(),
            'recentSubmissions' => Submission::latest()->with('user', 'task')->take(5)->get(),
        ]);
    }
}
