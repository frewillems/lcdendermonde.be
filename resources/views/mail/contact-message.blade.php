<x-mail::message>
# Nieuw bericht via de website

**Naam:** {{ $payload['naam'] }}  
**E-mail:** {{ $payload['email'] }}  
**Telefoon:** {{ $payload['telefoon'] ?: '—' }}

**Bericht**  
{{ $payload['bericht'] }}
</x-mail::message>
