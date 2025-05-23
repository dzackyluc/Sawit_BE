<?php

namespace App\Mail;

use App\Models\JanjiTemu;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JanjiTemuRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $janji;
    public $alasan;

    /**
     * Create a new message instance.
     */
    public function __construct(JanjiTemu $janji, string $alasan)
    {
        $this->janji  = $janji;
        $this->alasan = $alasan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Penolakan Pengajuan Jadwal Anda')
            ->markdown('emails.janji_temu.rejected')
            ->with([
                'nama'   => $this->janji->nama,
                'tanggal'=> $this->janji->tanggal,
                'jam'    => $this->janji->jam,
                'alasan' => $this->alasan,
            ]);
    }
}
