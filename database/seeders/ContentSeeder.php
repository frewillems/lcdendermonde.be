<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Member;
use App\Models\Page;
use App\Models\Project;
use App\Models\SiteEvent;
use App\Support\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $rank = [
            'voorzitster 2026-2027' => 1,
            'vice-voorzitster 2026-2027' => 2,
            'vice-voorzitster zone 1 2026-2027' => 3,
            'past-voorzitster 2026-2027' => 4,
            'secretaresse 2026-2027' => 5,
            'community service lady (csl) 2026-2027' => 6,
            'contact lady 2026-2027' => 7,
            'penning 2026-2027' => 8,
            'social media en weblady 2026-2027' => 9,
        ];

        foreach ($this->json('members.json') as $member) {
            Member::query()->updateOrCreate(
                ['slug' => $member['slug']],
                [
                    'name' => $member['name'],
                    'role' => $member['role'] ?? null,
                    'bio' => $member['bio'] ?? null,
                    'photo' => Media::relative($member['photo'] ?? null),
                    'group' => $member['group'] ?? 'lid',
                    'sort_order' => $rank[mb_strtolower((string) ($member['role'] ?? ''))] ?? 100,
                ],
            );
        }

        foreach ($this->json('projects.json') as $project) {
            Project::query()->updateOrCreate(
                ['slug' => $project['slug']],
                [
                    'title' => $project['title'],
                    'date_label' => $project['date_label'] ?? null,
                    'date' => $project['date'] ?? null,
                    'excerpt' => $project['excerpt'] ?? null,
                    'body' => $project['body'] ?? null,
                    'image' => Media::relative($project['image'] ?? null),
                    'images' => collect($project['images'] ?? [])->map(fn (string $path) => Media::relative($path))->all(),
                ],
            );
        }

        foreach ($this->json('events.json') as $event) {
            SiteEvent::query()->updateOrCreate(
                ['slug' => $event['slug']],
                [
                    'title' => $event['title'],
                    'date_label' => $event['date_label'] ?? null,
                    'body' => $event['body'] ?? null,
                    'image' => Media::relative($event['image'] ?? null),
                    'images' => collect($event['images'] ?? [])->map(fn (string $path) => Media::relative($path))->all(),
                    'related_album' => $event['related_album'] ?? null,
                ],
            );
        }

        foreach ($this->json('albums.json') as $album) {
            Album::query()->updateOrCreate(
                ['slug' => $album['slug']],
                [
                    'title' => $album['title'],
                    'images' => collect($album['images'] ?? [])->map(fn (string $path) => Media::relative($path))->all(),
                ],
            );
        }

        Page::query()->updateOrCreate(
            ['slug' => 'origin-story'],
            [
                'title' => 'Ons verhaal',
                'body' => File::get(resource_path('content/origin-story.txt')),
            ],
        );

        Page::query()->updateOrCreate(
            ['slug' => 'voorwaarden'],
            [
                'title' => 'Algemene voorwaarden',
                'body' => File::get(resource_path('content/pages/voorwaarden.md')),
            ],
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function json(string $filename): array
    {
        return json_decode(File::get(resource_path('content/'.$filename)), true, 512, JSON_THROW_ON_ERROR);
    }
}
