<?php

use App\Mail\JoinApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

new class extends Component
{
    public string $voornaam = '';

    public string $naam = '';

    public string $straat = '';

    public string $plaats = '';

    public string $postcode = '';

    public string $geboortedatum = '';

    public string $email = '';

    public string $gsm = '';

    public string $motivatie = '';

    public string $hoe = '';

    public string $website = '';

    public bool $sent = false;

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'voornaam' => 'required|string|max:80',
            'naam' => 'required|string|max:80',
            'straat' => 'required|string|max:160',
            'plaats' => 'required|string|max:80',
            'postcode' => 'required|string|max:12',
            'geboortedatum' => 'required|date',
            'email' => 'required|email',
            'gsm' => 'required|string|max:30',
            'motivatie' => 'required|string|max:4000',
            'hoe' => 'required|string|max:500',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'voornaam.required' => 'Vul je voornaam in.',
            'naam.required' => 'Vul je naam in.',
            'straat.required' => 'Vul je adres in.',
            'plaats.required' => 'Vul je gemeente in.',
            'postcode.required' => 'Vul je postcode in.',
            'geboortedatum.required' => 'Vul je geboortedatum in.',
            'email.required' => 'Vul je e-mailadres in.',
            'email.email' => 'Dit e-mailadres lijkt niet geldig.',
            'gsm.required' => 'Vul je gsm-nummer in.',
            'motivatie.required' => 'Vertel kort waarom je lid wilt worden.',
            'hoe.required' => 'Laat weten hoe je ons kent.',
        ];
    }

    public function send(): void
    {
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        $key = 'join-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', 'Je hebt te vaak verzonden. Probeer over een minuut opnieuw.');

            return;
        }

        $this->validate();

        RateLimiter::hit($key, 60);

        Mail::to(config('club.contact_email'))->send(new JoinApplication([
            'voornaam' => $this->voornaam,
            'naam' => $this->naam,
            'straat' => $this->straat,
            'plaats' => $this->plaats,
            'postcode' => $this->postcode,
            'geboortedatum' => $this->geboortedatum,
            'email' => $this->email,
            'gsm' => $this->gsm,
            'motivatie' => $this->motivatie,
            'hoe' => $this->hoe,
        ]));

        $this->sent = true;
    }
};
?>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-navy/5 sm:p-8">
    @if ($sent)
        <p class="font-serif text-2xl text-navy">Bedankt!</p>
        <p class="mt-3 text-muted">We hebben je kandidatuur goed ontvangen en nemen spoedig contact op.</p>
    @else
        <form wire:submit="send" class="grid gap-4 sm:grid-cols-2">
            <div class="hidden" aria-hidden="true">
                <label>Website <input type="text" wire:model="website" tabindex="-1" autocomplete="off"></label>
            </div>
            <label class="block text-sm font-medium">Voornaam *
                <input wire:model="voornaam" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('voornaam') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Naam *
                <input wire:model="naam" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('naam') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium sm:col-span-2">Straat + huisnummer *
                <input wire:model="straat" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('straat') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Postcode *
                <input wire:model="postcode" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('postcode') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Gemeente *
                <input wire:model="plaats" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('plaats') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Geboortedatum *
                <input type="date" wire:model="geboortedatum" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('geboortedatum') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Gsm *
                <input type="tel" wire:model="gsm" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('gsm') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium sm:col-span-2">E-mailadres *
                <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('email') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium sm:col-span-2">Motivatie *
                <textarea wire:model="motivatie" rows="4" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required></textarea>
                @error('motivatie') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium sm:col-span-2">Hoe ken je Ladies’ Circle Dendermonde? *
                <input wire:model="hoe" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('hoe') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <div class="sm:col-span-2">
                <button type="submit" class="rounded-full bg-navy px-6 py-3 text-sm font-semibold text-cream hover:bg-navy-deep" wire:loading.attr="disabled">Versturen</button>
            </div>
        </form>
    @endif
</div>
