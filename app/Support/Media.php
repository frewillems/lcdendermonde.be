<?php

namespace App\Support;

class Media
{
    public const MAX_UPLOAD_KB = 5120;

    public static function url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return '/media/'.$path;
    }

    public static function relative(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return ltrim(preg_replace('#^/media/#', '', $path) ?? $path, '/');
    }

    /**
     * @param  array<int, string>|null  $paths
     * @return array<int, string>
     */
    public static function urls(?array $paths): array
    {
        return collect($paths ?? [])
            ->map(fn (string $path) => self::url($path))
            ->filter()
            ->values()
            ->all();
    }
}
