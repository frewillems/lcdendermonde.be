<?php

namespace App\Content;

use App\Models\Album;
use App\Models\Member;
use App\Models\Page;
use App\Models\Project;
use App\Models\SiteEvent;
use Illuminate\Support\Collection;

class ContentRepository
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function members(): Collection
    {
        return Member::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (Member $member) => $member->toSiteArray())
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function board(): Collection
    {
        return Member::query()
            ->where('group', 'bestuur')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (Member $member) => $member->toSiteArray())
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function activeMembers(): Collection
    {
        return Member::query()
            ->where('group', 'lid')
            ->orderBy('name')
            ->get()
            ->map(fn (Member $member) => $member->toSiteArray())
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function senioritas(): Collection
    {
        return Member::query()
            ->where('group', 'seniorita')
            ->orderBy('name')
            ->get()
            ->map(fn (Member $member) => $member->toSiteArray())
            ->values();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function inMemoriam(): Collection
    {
        return Member::query()
            ->where('group', 'in-memoriam')
            ->orderBy('name')
            ->get()
            ->map(fn (Member $member) => $member->toSiteArray())
            ->values();
    }

    public function originStory(): string
    {
        return (string) Page::query()->where('slug', 'origin-story')->value('body');
    }

    public function pageBody(string $slug): string
    {
        return (string) Page::query()->where('slug', $slug)->value('body');
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function projects(): Collection
    {
        return Project::query()
            ->orderByDesc('date')
            ->get()
            ->map(fn (Project $project) => $project->toSiteArray())
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
        return Project::query()->where('slug', $slug)->first()?->toSiteArray();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function albums(): Collection
    {
        return Album::query()
            ->orderBy('title')
            ->get()
            ->map(fn (Album $album) => $album->toSiteArray())
            ->values();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function album(string $slug): ?array
    {
        return Album::query()->where('slug', $slug)->first()?->toSiteArray();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function events(): Collection
    {
        return SiteEvent::query()
            ->orderBy('title')
            ->get()
            ->map(fn (SiteEvent $event) => $event->toSiteArray())
            ->values();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function event(string $slug): ?array
    {
        return SiteEvent::query()->where('slug', $slug)->first()?->toSiteArray();
    }
}
