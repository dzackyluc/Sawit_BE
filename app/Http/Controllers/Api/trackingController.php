<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;

class trackingController extends Controller
{
    // Simpan update lokasi
    public function store(Request $request)
    {
        $data = $request->validate([
            'task_id'     => 'required|exists:tasks,id',
            'pengepul_id' => 'required|exists:users,id',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
        ]);

        $tracking = Tracking::create($data);

        return response()->json($tracking, 201);
    }

    // Semua update lokasi untuk sebuah task
    public function indexByTask($taskId)
    {
        $trackings = Tracking::where('task_id', $taskId)
                            ->orderBy('created_at')
                            ->get();

        return response()->json($trackings);
    }
}
