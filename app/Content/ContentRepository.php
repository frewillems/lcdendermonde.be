<?php

namespace App\Content;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ContentRepository
{
    /** @var array<string, mixed> */
    private array $cache = [];

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function members(): Collection
    {
        return $this->collection('members.json')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function board(): Collection
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

        return $this->members()
            ->where('group', 'bestuur')
            ->sortBy(fn (array $member) => $rank[mb_strtolower($member['role'])] ?? 20)
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function activeMembers(): Collection
    {
        return $this->members()->where('group', 'lid')->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function senioritas(): Collection
    {
        return $this->members()->where('group', 'seniorita')->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function inMemoriam(): Collection
    {
        return $this->members()->where('group', 'in-memoriam')->values();
    }

    public function originStory(): string
    {
        return File::get(resource_path('content/origin-story.txt'));
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function projects(): Collection
    {
        return $this->collection('projects.json')
            ->sortByDesc('date')
            ->values();
    }

    /**
     * @return Collection<string, Collection<int, array<string, mixed>>>
     */
    public function projectsByYear(): Collection
    {
        return $this->projects()->groupBy(fn (array $project) => substr((string) $project['date'], 0, 4));
    }

    /**
     * @return array<string, mixed>|null
     */
    public function project(string $slug): ?array
    {
        return $this->projects()->firstWhere('slug', $slug);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function albums(): Collection
    {
        return $this->collection('albums.json');
    }

    /**
     * @return array<string, mixed>|null
     */
    public function album(string $slug): ?array
    {
        return $this->albums()->firstWhere('slug', $slug);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function events(): Collection
    {
        return $this->collection('events.json');
    }

    /**
     * @return array<string, mixed>|null
     */
    public function event(string $slug): ?array
    {
        return $this->events()->firstWhere('slug', $slug);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function collection(string $filename): Collection
    {
        if (! isset($this->cache[$filename])) {
            $path = resource_path('content/'.$filename);
            $this->cache[$filename] = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        }

        return collect($this->cache[$filename]);
    }
}
