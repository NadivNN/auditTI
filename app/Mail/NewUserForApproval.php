<?php

namespace App\Mail;

use App\Models\User; // Import model User
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewUserForApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Instance pengguna baru.
     *
     * @var \App\Models\User
     */
    public User $user;

    /**
     * Buat instance pesan baru.
     * Kita akan menerima data user yang baru mendaftar.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Dapatkan "amplop" pesan (subjek, pengirim, dll).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Persetujuan User Baru'
        );
    }

    /**
     * Dapatkan konten pesan.
     * Kita akan menggunakan template markdown yang rapi.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.new-user-approval' // Ini adalah path ke file view email
        );
    }

    /**
     * Dapatkan lampiran untuk pesan.
     */
    public function attachments(): array
    {
        return [];
    }
}
