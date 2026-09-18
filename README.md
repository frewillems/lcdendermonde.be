# Ladies’ Circle Dendermonde

Nieuwe website voor [lcdendermonde.be](https://lcdendermonde.be): Laravel, Blade, Tailwind CSS en Livewire. Content zit in git (`resources/content` + `public/media`).

## Lokaal draaien

Vereisten: PHP 8.3+, Composer, Node 22+.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run dev
```

In een tweede terminal:

```bash
php artisan serve
```

De site is dan bereikbaar op http://localhost:8000.

## Content wijzigen

- Leden: `resources/content/members.json` + foto in `public/media/leden/`
- Projecten: `resources/content/projects.json` + beelden in `public/media/projecten/`
- Evenementen: `resources/content/events.json`
- Albums: `resources/content/albums.json`
- Clubgegevens (adres, IBAN, nav): `config/club.php`

Daarna deployen. Er is geen admin-panel.

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
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Wijs `lcdendermonde.be` naar `public/` wanneer de nieuwe site de WordPress-installatie vervangt.
