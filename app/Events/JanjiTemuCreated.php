<?php

// app/Events/JanjiTemuCreated.php
namespace App\Events;

use App\Models\JanjiTemu;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class JanjiTemuCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $janji;

    public function __construct(JanjiTemu $janji)
    {
        $this->janji = $janji;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('manager.janji-temu');
    }

    public function broadcastAs()
    {
        return 'JanjiTemuCreated';
    }

    public function broadcastWith()
    {
        return [
            'id'          => $this->janji->id,
            'nama_petani' => $this->janji->nama_petani,
            'tanggal'     => $this->janji->tanggal,
            'alamat'      => $this->janji->alamat,
            'status'      => $this->janji->status,
        ];
    }
}
