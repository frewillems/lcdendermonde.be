<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use App\Mail\JoinApplication;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class SiteTest extends TestCase
{
    public function test_home_page_renders(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Friendship')
            ->assertSee('Lid worden');
    }

    public function test_core_pages_render(): void
    {
        $this->get('/info-club')->assertOk()->assertSee('LC13 Dendermonde');
        $this->get('/leden')->assertOk()->assertSee('Jazmin Van den Broeck');
        $this->get('/projecten')->assertOk()->assertSee('Onze projecten');
        $this->get('/lid-worden')->assertOk()->assertSee('Lid worden');
        $this->get('/contact')->assertOk()->assertSee('contactlady');
        $this->get('/rose-bestellen')->assertOk()->assertSee('olijfolie', false);
        $this->get('/algemene-voorwaarden-bestel-en-levervoorwaarden')->assertOk()->assertSee('Algemene');
    }

    public function test_project_and_archive_pages_render(): void
    {
        $this->get('/projecten/juli-2025')->assertOk()->assertSee('Walibi');
        $this->get('/album-dagenraad')->assertOk();
        $this->get('/impressies-annual-witches-ball-2018')->assertOk();
        $this->get('/fotoreportage-recharter')->assertOk();
        $this->get('/spinning-for-charity')->assertOk()->assertSee('Spinning');
        $this->get('/recharter')->assertOk();
    }

    public function test_legacy_urls_redirect(): void
    {
        $this->get('/home')->assertRedirect('/');
        $this->get('/no-access')->assertRedirect('/');
        $this->get('/onze-rose-verkoop-is-open-2')->assertRedirect('/rose-bestellen');
    }

    public function test_sitemap_is_xml(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('projecten/juli-2025', false);
    }

    public function test_join_form_validates_and_sends_mail(): void
    {
        Mail::fake();

        Livewire::test('join-form')
            ->set('voornaam', 'Anna')
            ->set('naam', 'Peeters')
            ->set('straat', 'Kerkstraat 1')
            ->set('plaats', 'Dendermonde')
            ->set('postcode', '9200')
            ->set('geboortedatum', '1995-04-12')
            ->set('email', 'anna@example.com')
            ->set('gsm', '0470000000')
            ->set('motivatie', 'Ik wil me inzetten voor lokale projecten.')
            ->set('hoe', 'Via Facebook')
            ->call('send')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        Mail::assertSent(JoinApplication::class);
    }

    public function test_join_form_requires_fields(): void
    {
        Livewire::test('join-form')
            ->call('send')
            ->assertHasErrors(['voornaam', 'naam', 'email']);
    }

    public function test_join_honeypot_does_not_mail(): void
    {
        Mail::fake();

        Livewire::test('join-form')
            ->set('website', 'http://spam.test')
            ->set('voornaam', 'Bot')
            ->call('send')
            ->assertSet('sent', true);

        Mail::assertNothingSent();
    }

    public function test_contact_form_sends_mail(): void
    {
        Mail::fake();

        Livewire::test('contact-form')
            ->set('naam', 'Jan')
            ->set('email', 'jan@example.com')
            ->set('bericht', 'Vraag over de rosé.')
            ->call('send')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        Mail::assertSent(ContactMessage::class);
    }

    public function test_unknown_project_is_404(): void
    {
        $this->get('/projecten/bestaat-niet')->assertNotFound();
    }
}
