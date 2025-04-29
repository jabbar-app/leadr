<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'username' => ['required', 'string', 'max:255', 'unique:organizations,username'],
            'api_url' => ['required', 'url', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[1-9][0-9]{7,15}$/'],
        ]);

        Organization::create($request->all());

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'username' => ['required', 'string', 'max:255', 'unique:organizations,username,' . $organization->id],
            'api_url' => ['required', 'url', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[1-9][0-9]{7,15}$/'],
        ]);

        $organization->update($request->all());

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil dihapus.');
    }

    public function leaderboard(Request $request, Organization $organization)
    {
        $selectedDate = $request->input('date') ?? now()->toDateString();

        // Ambil user dari organisasi yang memiliki submission di tanggal itu
        $users = $organization->users()
            ->with(['submissions' => function ($query) use ($selectedDate) {
                $query->where('status', 'approved')
                    ->whereDate('submitted_at', $selectedDate);
            }])
            ->get()
            ->filter(function ($user) {
                return $user->submissions->count() > 0;
            })
            ->map(function ($user) {
                $user->total_score = $user->submissions->sum('score');
                $user->earliest_submission_time = $user->submissions->min('submitted_at');
                return $user;
            })
            ->sortByDesc('total_score')
            ->sortBy('earliest_submission_time')
            ->values();

        // Navigasi hari
        $previousDate = Carbon::parse($selectedDate)->subDay()->toDateString();
        $nextDate = Carbon::parse($selectedDate)->addDay()->toDateString();

        return view('organizations.leaderboard', compact(
            'organization',
            'users',
            'selectedDate',
            'previousDate',
            'nextDate'
        ));
    }
}
