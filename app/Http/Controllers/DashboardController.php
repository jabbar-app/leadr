<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = User::find(Auth::id());

        $today = now()->toDateString();

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
        $tasks = Task::dueToday()
            ->where('organization_id', $user->organization_id)
            ->get()
            ->filter(function ($task) use ($user, $today) {
                return !$task->submissions()
                    ->where('user_id', $user->id)
                    ->whereDate('submitted_at', $today)
                    ->exists();
            });

        // Submissions user
        $submittedTasks = $user->submissions()
            ->pending()
            ->with('task')
            ->get()
            ->filter(fn($s) => $s->task && $s->task->isDueToday())
            ->pluck('task');

        $completedTasks = $user->submissions()
            ->approved()
            ->with('task')
            ->get()
            ->filter(fn($s) => $s->task && $s->task->isDueToday())
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
}
