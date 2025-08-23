<?php

namespace App\Mail;

use App\Models\IncidentMitigation;
use App\Models\Mitigation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentMitigatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mitigation;

    public function __construct(IncidentMitigation $mitigation)
    {
        $this->mitigation = $mitigation;
    }

    public function build()
    {
        return $this->subject('Incident Mitigated')
                    ->markdown('emails.incidents.mitigated');
    }
}
