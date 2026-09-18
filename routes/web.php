<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/info-club', [SiteController::class, 'infoClub'])->name('info-club');
Route::get('/leden', [SiteController::class, 'leden'])->name('leden');
Route::get('/projecten', [SiteController::class, 'projecten'])->name('projecten');
Route::get('/projecten/{slug}', [SiteController::class, 'project'])->name('project');
Route::get('/lid-worden', [SiteController::class, 'lidWorden'])->name('lid-worden');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/rose-bestellen', [SiteController::class, 'rose'])->name('rose-bestellen');
Route::get('/algemene-voorwaarden-bestel-en-levervoorwaarden', [SiteController::class, 'voorwaarden'])->name('voorwaarden');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

Route::get('/{slug}', [SiteController::class, 'archive'])
    ->whereIn('slug', [
        'impressies-annual-witches-ball-2018',
        'album-dagenraad',
        'fotoreportage-recharter',
        'spinning-for-charity',
        'sponsoring-spinning-for-charity',
        'sponsoring-witches-ball-2025',
        'inschrijvingsformulier-magical-witches-ball-2025',
        'candle-light-diner-with-the-witches',
        'the-witches-night',
        'recharter',
        'inschrijving-recharter',
    ])
    ->name('archive');

Route::permanentRedirect('/home', '/');
Route::permanentRedirect('/home/', '/');
Route::permanentRedirect('/no-access', '/');
Route::permanentRedirect('/no-access/', '/');
Route::permanentRedirect('/onze-rose-verkoop-is-open-2', '/rose-bestellen');
Route::permanentRedirect('/onze-rose-verkoop-is-open-2/', '/rose-bestellen');
