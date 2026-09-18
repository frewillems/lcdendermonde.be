# Ladies’ Circle Dendermonde

Nieuwe website voor [lcdendermonde.be](https://lcdendermonde.be): Laravel, Blade, Tailwind CSS, Livewire en Filament. Content zit in de database. De seed-import (`resources/content` + `public/media`) vult lege tabellen; daarna is het admin-panel de bron.

## Lokaal draaien

Vereisten: PHP 8.3+, Composer, Node 22+.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run dev
```

In een tweede terminal:

```bash
php artisan serve
```

De site is dan bereikbaar op http://localhost:8000.

## Admin

Het CMS zit op http://localhost:8000/admin

Lokale login na `migrate --seed` (aanpasbaar in `.env` **vóór** de eerste seed):

- E-mail: `ADMIN_EMAIL` (standaard `weblady@lcdendermonde.be`)
- Wachtwoord: `ADMIN_PASSWORD` (standaard `password` — alleen voor lokaal)

Wijzig het wachtwoord meteen in het panel. Opnieuw seeden overschrijft bestaande leden, projecten of het admin-wachtwoord **niet**. Extra accounts geef je toegang via `ADMIN_EMAILS` (komma-gescheiden).

Daarin beheer je leden, projecten, evenementen, albums, pagina’s (ons verhaal en de voorwaarden) en de berichten van de join- en contactformulieren. Nieuwe foto’s komen in `public/media` en moeten op de server blijven staan bij een deploy.

Clubgegevens zoals adres en IBAN blijven in `config/club.php`.

## Mail

Join- en contactformulieren mailen naar `contactlady@lcdendermonde.be`. Lokaal gebruikt `.env` de `log`-mailer (zie `storage/logs`). In productie: SMTP van de clubmailbox instellen (`MAIL_MAILER=smtp`, host/user/password).

## Tests

```bash
php artisan test
```

## Productie

PHP 8.3+, Composer, Node voor de Vite-build. Document root is `public/`.

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan db:seed --force   # alleen de eerste keer, op een lege database
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Maak de productie-admin met een sterk wachtwoord (`ADMIN_PASSWORD` in `.env` vóór de eerste seed, of `php artisan make:filament-user` plus `ADMIN_EMAILS`). Seed daarna niet opnieuw op een gevulde database.

Wijs `lcdendermonde.be` naar `public/` wanneer de nieuwe site de WordPress-installatie vervangt.
