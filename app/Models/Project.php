<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'date_label', 'date', 'excerpt', 'body', 'image', 'images'])]
class Project extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'images' => 'array',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toSiteArray(): array
    {
        $images = Media::urls($this->images);

        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'date_label' => $this->date_label,
            'date' => optional($this->date)?->toDateString(),
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'image' => Media::url($this->image) ?? ($images[0] ?? null),
            'images' => $images,
        ];
    }
}
