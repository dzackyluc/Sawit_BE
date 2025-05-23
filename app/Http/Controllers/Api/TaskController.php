<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\JanjiTemu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Mail;


class TaskController extends Controller
{

    public function getTasksByPengepul(Request $request)
    {
        $user = $request->user(); // user pengepul yang login

        // Filter tugas berdasarkan pengepul_id sesuai user login
        $tasks = Task::with(['janjiTemu', 'pengepul'])
                    ->where('pengepul_id', $user->id)
                    ->get();

        return response()->json([
            'debug' => 'Masuk ke method getTasksByPengepul',
            'success' => true,
            'data' => $tasks,
        ], 200);
    }

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
     * Mengirimkan Tugas ke Pengepul dan mengirimkan email 
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'janji_temu_id' => 'required|exists:janji_temu,id',
            'pengepul_id'   => 'required|exists:users,id',
        ]);

        $now = Carbon::now();
        $namaTask = 'Tugas ' . $now->format('is'); 

        $task = Task::create([
            'janji_temu_id' => $data['janji_temu_id'], 
            'pengepul_id'   => $data['pengepul_id'],
            'status'        => 'pending',
            'nama_task'     => $namaTask,
        ]);

        JanjiTemu::where('id', $data['janji_temu_id'])->update(['status' => 'approved']);

        // Kirim email ke pengepul
        $pengepul = \App\Models\User::find($data['pengepul_id']);
        Mail::to($pengepul->email)->send(new TaskAssignedMail($task));

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => 'Task created, janji temu approved, and email sent',
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
            'status' => 'sometimes|in:pending,accepted,rejected,in_progress,completed',
            'pengepul_id' => 'sometimes|exists:users,id',
        ]);

        $oldStatus = $task->status;
        $oldPengepulId = $task->pengepul_id;

        $task->update($validated);

        $newStatus = $task->status;
        $newPengepulId = $task->pengepul_id;

        // Kirim email jika status berubah ke accepted atau pengepul_id diganti
        if (
            ($oldStatus !== 'accepted' && $newStatus === 'accepted') 
            || ($oldPengepulId != $newPengepulId)
        ) {
            $pengepul = \App\Models\User::find($newPengepulId);
            if ($pengepul) {
                try {
                    Mail::to($pengepul->email)->send(new TaskAssignedMail($task));
                } catch (\Exception $e) {
                    \Log::error('Gagal kirim email update task: ' . $e->getMessage());
                }
            }
        }

        return response()->json([
            'success' => true,
            'data'    => $task,
            'message' => 'Task updated',
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

    // Code ketik pengepul menerima tugas dan mengirimkan lokasinya 
    public function accepted(Request $request, string $id)
    {
        $request->validate([
            'pul_latitude'  => 'required|numeric',
            'pul_longitude' => 'required|numeric',
        ]);

        $task = Task::findOrFail($id);

        $task->status = 'in_progress';
        $task->pul_latitude = $request->pul_latitude;
        $task->pul_longitude = $request->pul_longitude;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task accepted and location saved',
            'data'    => $task,
        ], 200);
    }

    public function updateLocation(Request $request, string $id)
    {
        $request->validate([
            'pul_latitude'  => 'required|numeric',
            'pul_longitude' => 'required|numeric',
        ]);

        $task = Task::findOrFail($id);
        $task->pul_latitude = $request->pul_latitude;
        $task->pul_longitude = $request->pul_longitude;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Location updated',
            'data'    => $task,
        ]);
    }

}
