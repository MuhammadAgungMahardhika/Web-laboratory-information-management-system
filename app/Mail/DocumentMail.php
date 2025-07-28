<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment; // Import Attachment
use Illuminate\Queue\SerializesModels;

class DocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $markdownView;
    public array $mailData;
    public array $attachmentsData; // Array for attachments

    /**
     * Create a new message instance.
     *
     * @param string $subject Subject of the email
     * @param string $markdownView Blade view for the email body (e.g., 'emails.document')
     * @param array $viewData Data to pass to the Markdown view
     * @param array $attachments Array of arrays: ['content' => ..., 'name' => ..., 'mime' => ...]
     */
    public function __construct(
        string $subject,
        string $markdownView,
        array $mailData = [],
        array $attachmentsData = []
    ) {
        $this->emailSubject = $subject;
        $this->markdownView = $markdownView;
        $this->mailData = $mailData;
        $this->attachmentsData = $attachmentsData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->markdownView,
            with: $this->viewData, // Pass dynamic data to the Markdown view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        foreach ($this->attachmentsData as $attachment) {
            $attachments[] = Attachment::fromData(fn() => $attachment['content'], $attachment['name'])
                ->withMime($attachment['mime']);
        }
        return $attachments;
    }
}
