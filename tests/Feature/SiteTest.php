<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use App\Mail\JoinApplication;
use App\Models\Album;
use App\Models\Member;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Database\Seeders\DatabaseSeeder;
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

        Mail::assertNothingOutgoing();
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

    public function test_admin_login_is_available(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->get('/admin')->assertRedirect();
    }

    public function test_join_form_stores_a_submission(): void
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
            ->call('send');

        $this->assertDatabaseHas('form_submissions', [
            'type' => 'join',
            'email' => 'anna@example.com',
        ]);
    }

    public function test_reseeding_does_not_overwrite_cms_edits(): void
    {
        $member = Member::query()->where('slug', 'jazmin-van-den-broeck')->first();
        $this->assertNotNull($member);
        $member->update(['bio' => 'CMS-bewerking']);

        $this->seed(ContentSeeder::class);

        $this->assertSame('CMS-bewerking', $member->fresh()->bio);
    }

    public function test_reseeding_does_not_reset_admin_password(): void
    {
        $admin = User::query()->where('email', config('club.admin_email'))->first();
        $this->assertNotNull($admin);
        $admin->update(['password' => 'gewijzigd-wachtwoord']);
        $hash = $admin->fresh()->password;

        $this->seed(DatabaseSeeder::class);

        $this->assertSame($hash, $admin->fresh()->password);
    }

    public function test_non_admin_cannot_access_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_open_the_panel(): void
    {
        $admin = User::query()->where('email', config('club.admin_email'))->first();
        $this->assertNotNull($admin);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_new_album_appears_on_projecten(): void
    {
        Album::query()->create([
            'slug' => 'nieuw-testalbum',
            'title' => 'Nieuw testalbum',
            'images' => [],
        ]);

        $this->get('/projecten')
            ->assertOk()
            ->assertSee('Nieuw testalbum')
            ->assertSee('Spinning for Charity');
    }

    public function test_origin_story_renders_markdown(): void
    {
        Page::query()->where('slug', 'origin-story')->update([
            'body' => 'Hallo **weblady**.',
        ]);

        $this->get('/leden')
            ->assertOk()
            ->assertSee('<strong>weblady</strong>', false);
    }
}
