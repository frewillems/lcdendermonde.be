<?php

namespace App\Support;

use App\Models\Album;
use App\Models\SiteEvent;
use Closure;

class ArchiveSlug
{
    /**
     * @return list<string>
     */
    public static function reserved(): array
    {
        return [
            'admin',
            'livewire',
            'up',
            'storage',
            'home',
            'info-club',
            'leden',
            'projecten',
            'lid-worden',
            'contact',
            'rose-bestellen',
            'algemene-voorwaarden-bestel-en-levervoorwaarden',
            'sitemap',
        ];
    }

    public static function isReserved(string $slug): bool
    {
        return in_array($slug, self::reserved(), true);
    }

    /**
     * Extra Filament rules so album and event slugs stay unique across the shared /{slug} namespace.
     *
     * @return array<int, Closure>
     */
    public static function rules(string $otherTable): array
    {
        return [
            function (string $attribute, mixed $value, Closure $fail) use ($otherTable): void {
                $slug = (string) $value;

                if (self::isReserved($slug)) {
                    $fail('Deze slug is gereserveerd voor een vaste pagina.');

                    return;
                }

                $taken = match ($otherTable) {
                    'events' => SiteEvent::query()->where('slug', $slug)->exists(),
                    'albums' => Album::query()->where('slug', $slug)->exists(),
                    default => false,
                };

                if ($taken) {
                    $fail('Deze slug wordt al gebruikt door een ander archiefitem.');
                }
            },
        ];
    }
}
