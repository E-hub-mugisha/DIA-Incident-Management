@component('mail::message')
# 🚨 New Incident Reported

**Title:** {{ $incident->title }}  
**Description:** {{ $incident->description }}  
**Status:** {{ ucfirst($incident->status) }}

@component('mail::button', ['url' => route('incidents.show', $incident->id)])
View Incident
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
