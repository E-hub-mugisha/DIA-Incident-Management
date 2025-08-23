{{-- resources/views/emails/incidents/assigned.blade.php --}}
@component('mail::message')
# New Incident Assigned

Hello **{{ optional($incident->assignedTo)->name }}**,

You have been assigned to an incident.

- **ID:** {{ $incident->id }}
- **Title:** {{ $incident->title }}
- **Category:** {{ optional($incident->category)->name ?? 'N/A' }}
- **Severity:** {{ ucfirst($incident->severity) }}
- **Status:** {{ ucwords(str_replace('_',' ', $incident->status)) }}
- **Location:** {{ $incident->location ?? 'N/A' }}

@component('mail::button', ['url' => route('incidents.show', $incident->id)])
View Incident
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
