<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Submission;
use App\Models\Organization;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function landing()
    {
        $taskCount = Task::count();
        $participantCount = User::where('role', 'participant')->count();
        $organizationCount = Organization::count();

        return view('landing', compact('taskCount', 'participantCount', 'organizationCount'));
    }

    public function organization(Organization $organization)
    {
        $memberCount = $organization->users()->count();

        $completedTasksCount = Submission::where('status', 'approved')
            ->whereHas('user', fn($q) => $q->where('organization_id', $organization->id))
            ->count();

        $totalScore = Submission::where('status', 'approved')
            ->whereHas('user', fn($q) => $q->where('organization_id', $organization->id))
            ->sum('score');

        return view('pages.organization', compact('organization', 'memberCount', 'completedTasksCount', 'totalScore'));
    }
}
