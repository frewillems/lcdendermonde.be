<?php

namespace App\Http\Controllers;

use App\Content\ContentRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SiteController extends Controller
{
    public function __construct(private ContentRepository $content) {}

    public function home(): View
    {
        return view('pages.home', [
            'projects' => $this->content->projects()->take(4),
            'board' => $this->content->board(),
        ]);
    }

    public function infoClub(): View
    {
        return view('pages.info-club');
    }

    public function leden(): View
    {
        return view('pages.leden', [
            'originStory' => $this->content->originStory(),
            'board' => $this->content->board(),
            'active' => $this->content->activeMembers(),
            'senioritas' => $this->content->senioritas(),
            'inMemoriam' => $this->content->inMemoriam(),
        ]);
    }

    public function projecten(): View
    {
        return view('pages.projecten', [
            'years' => $this->content->projectsByYear(),
        ]);
    }

    public function project(string $slug): View
    {
        $project = $this->content->project($slug);

        abort_if($project === null, SymfonyResponse::HTTP_NOT_FOUND);

        return view('pages.project', [
            'project' => $project,
            'related' => $this->content->projects()->where('slug', '!=', $slug)->take(3),
        ]);
    }

    public function lidWorden(): View
    {
        return view('pages.lid-worden');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function rose(): View
    {
        return view('pages.rose-bestellen');
    }

    public function voorwaarden(): View
    {
        return view('pages.voorwaarden', [
            'body' => $this->content->pageBody('voorwaarden'),
        ]);
    }

    public function archive(string $slug): View
    {
        $album = $this->content->album($slug);

        if ($album !== null) {
            return view('pages.album', ['album' => $album]);
        }

        $event = $this->content->event($slug);

        abort_if($event === null, SymfonyResponse::HTTP_NOT_FOUND);

        return view('pages.event', ['event' => $event]);
    }

    public function sitemap(): Response
    {
        $urls = collect([
            route('home'),
            route('info-club'),
            route('leden'),
            route('projecten'),
            route('lid-worden'),
            route('contact'),
            route('rose-bestellen'),
            route('voorwaarden'),
        ]);

        $urls = $urls
            ->merge($this->content->projects()->map(fn (array $project) => route('project', $project['slug'])))
            ->merge($this->content->events()->map(fn (array $event) => route('archive', $event['slug'])))
            ->merge($this->content->albums()->map(fn (array $album) => route('archive', $album['slug'])));

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
