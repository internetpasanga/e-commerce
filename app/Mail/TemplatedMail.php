<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplatedMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $renderedSubject;

    private string $renderedBody;

    /**
     * @param  array<string, string>  $variables
     */
    public function __construct(string $slug, array $variables = [])
    {
        $rendered = EmailTemplate::render($slug, $variables);

        $this->renderedSubject = $rendered['subject'];
        $this->renderedBody = $rendered['body'];
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->renderedSubject);
    }

    public function content(): Content
    {
        return new Content(htmlString: $this->renderedBody);
    }
}
