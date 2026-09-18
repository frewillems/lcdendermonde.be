<?php

use App\Mail\ContactMessage;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

new class extends Component
{
    public string $naam = '';

    public string $email = '';

    public string $telefoon = '';

    public string $bericht = '';

    public string $website = '';

    public bool $sent = false;

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'naam' => 'required|string|max:120',
            'email' => 'required|email',
            'telefoon' => 'nullable|string|max:30',
            'bericht' => 'required|string|max:4000',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'naam.required' => 'Vul je naam in.',
            'email.required' => 'Vul je e-mailadres in.',
            'email.email' => 'Dit e-mailadres lijkt niet geldig.',
            'bericht.required' => 'Schrijf een kort bericht.',
        ];
    }

    public function send(): void
    {
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        $key = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('email', 'Je hebt te vaak verzonden. Probeer over een minuut opnieuw.');

            return;
        }

        $this->validate();

        RateLimiter::hit($key, 60);

        $payload = [
            'naam' => $this->naam,
            'email' => $this->email,
            'telefoon' => $this->telefoon,
            'bericht' => $this->bericht,
        ];

        FormSubmission::query()->create([
            'type' => 'contact',
            'name' => $this->naam,
            'email' => $this->email,
            'payload' => $payload,
        ]);

        Mail::to(config('club.contact_email'))->send(new ContactMessage($payload));

        $this->sent = true;
    }
};
?>

<div class="panel p-6 sm:p-8">
    @if ($sent)
        <p class="font-serif text-2xl text-navy">Verzonden</p>
        <p class="mt-3 text-muted">Dankjewel. We beantwoorden je bericht zo snel mogelijk.</p>
    @else
        <form wire:submit="send" class="grid gap-4">
            <div class="hidden" aria-hidden="true">
                <label>Website <input type="text" wire:model="website" tabindex="-1" autocomplete="off"></label>
            </div>
            <label class="block text-sm font-medium">Naam *
                <input wire:model="naam" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('naam') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">E-mailadres *
                <input type="email" wire:model="email" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required>
                @error('email') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <label class="block text-sm font-medium">Telefoon
                <input type="tel" wire:model="telefoon" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold">
            </label>
            <label class="block text-sm font-medium">Bericht *
                <textarea wire:model="bericht" rows="6" class="mt-1 w-full rounded-lg border-0 bg-cream px-3 py-2.5 ring-1 ring-navy/10 focus:ring-2 focus:ring-gold" required></textarea>
                @error('bericht') <span class="text-sm text-red-700">{{ $message }}</span> @enderror
            </label>
            <button type="submit" class="btn" wire:loading.attr="disabled">Versturen</button>
        </form>
    @endif
</div>
