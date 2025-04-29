<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::latest()->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organizations = Organization::all();
        return view('tasks.create', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'score' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
            'is_recurring' => 'nullable|boolean',
            'recurring_type' => 'nullable|in:daily,weekly,monthly',
        ]);

        $task = new Task();
        $task->organization_id = Auth::user()->organization_id;
        $task->title = $validated['title'];
        $task->description = $validated['description'] ?? null;
        $task->score = $validated['score'];
        $task->due_date = $validated['due_date'] ?? null;
        $task->is_recurring = $request->boolean('is_recurring');
        $task->recurring_type = $task->is_recurring ? $validated['recurring_type'] : null;
        $task->save();

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $organizations = Organization::all();
        return view('tasks.edit', compact('task', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'score' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
            'is_recurring' => 'nullable|boolean',
            'recurring_type' => 'nullable|in:daily,weekly,monthly',
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'score' => $validated['score'],
            'due_date' => $validated['due_date'] ?? null,
            'is_recurring' => $request->boolean('is_recurring'),
            'recurring_type' => $request->boolean('is_recurring') ? $validated['recurring_type'] : null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
