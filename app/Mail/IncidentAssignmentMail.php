<?php

namespace App\Mail;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidentAssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public Incident $incident; // public so Blade can access it

    public function __construct(Incident $incident)
    {
        // eager-load a few relations used in the email (optional)
        $this->incident = $incident->load('category', 'reportedBy', 'assignedTo');
    }

    public function build()
    {
        return $this->subject('Incident Assigned: '.$this->incident->title)
                    ->markdown('emails.incidents.assignment'); // Blade can use $incident directly
        // Alternatively: ->view('emails.incidents.assigned')->with(['incident' => $this->incident])
    }
}
