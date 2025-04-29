<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TaskAssigned;


class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index()
    {
        // Eager load janjiTemu and pengepul if relationships defined
        $tasks = Task::with(['janjiTemu', 'pengepul'])->get();

        return response()->json([
            'success' => true,
            'data'    => $tasks,
        ], 200);
    }

    /**
     * Store a newly created task and notify the assigned pengepul.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'janji_temu_id' => 'required|exists:janji_temu,id',
            'pengepul_id'   => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'janji_temu_id' => $data['janji_temu_id'],  // FK to JanjiTemu
            'pengepul_id'   => $data['pengepul_id'],
            'status'        => 'pending',
        ]);

        // Notify the assigned pengepul
        $pengepul = User::findOrFail($data['pengepul_id']);
        $pengepul->notify(new TaskAssigned($task));

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => 'Task created and notification sent',
        ], 201);
    }

    /**
     * Display the specified task.
     */
    public function show(string $id)
    {
        $task = Task::with(['janjiTemu', 'pengepul'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $task,
        ], 200);
    }

    /**
     * Update the specified task's status.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected,in_progress,completed',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => 'Task status updated',
        ], 200);
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(string $id)
    {
        Task::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted',
        ], 200);
    }
}
