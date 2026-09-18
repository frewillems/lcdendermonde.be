<x-mail::message>
# Nieuwe lidkandidatuur

**Naam:** {{ $payload['voornaam'] }} {{ $payload['naam'] }}  
**Adres:** {{ $payload['straat'] }}, {{ $payload['postcode'] }} {{ $payload['plaats'] }}  
**Geboortedatum:** {{ $payload['geboortedatum'] }}  
**E-mail:** {{ $payload['email'] }}  
**Gsm:** {{ $payload['gsm'] }}

**Motivatie**  
{{ $payload['motivatie'] }}

**Hoe kent ze LC Dendermonde?**  
{{ $payload['hoe'] }}
</x-mail::message>
