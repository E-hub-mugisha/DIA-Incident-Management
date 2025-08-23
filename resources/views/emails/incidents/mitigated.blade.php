@component('mail::message')
# ✅ Incident Mitigated

The following incident has been resolved:

**Incident:** {{ $mitigation->incident->title }}

**Mitigation:** {{ $mitigation->mitigation }}  
**Mitigated By:** {{ $mitigation->user->name ?? 'System' }}

@component('mail::button', ['url' => route('incidents.show', $mitigation->incident_id)])
View Details
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
