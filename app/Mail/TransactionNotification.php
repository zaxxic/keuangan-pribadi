<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $amount;
    public $name;


    /**
     * Create a new message instance.
     */
    public function __construct($content, $amount, $name)
    {
        $this->content = $content;
        $this->amount = $amount;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Transaction Notification ';

        // Mengganti nilai $content jika diperlukan
        if ($this->content === 'income') {
            $subject .= 'Pemasukan';
        } elseif ($this->content === 'expenditure') {
            $subject .= 'Pengeluaran';
        } else {
            $subject .= $this->content;
        }

        return new Envelope(
            subject: $subject
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
