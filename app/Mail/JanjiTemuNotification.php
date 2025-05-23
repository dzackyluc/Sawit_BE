<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JanjiTemuNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $janji;

    public function __construct($janji)
    {
        $this->janji = $janji;
    }

    public function build()
    {
        return $this->subject('Permintaan Janji Temu Baru')
                    ->view('emails.janji_temu.janji-temu-html') // gunakan HTML custom
                    ->with([
                        'janji' => $this->janji
                    ]);
    }
}
