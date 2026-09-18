<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'date_label', 'body', 'image', 'images', 'related_album'])]
class SiteEvent extends Model
{
    protected $table = 'events';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
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
            'body' => $this->body,
            'image' => Media::url($this->image) ?? ($images[0] ?? null),
            'images' => $images,
            'related_album' => $this->related_album,
        ];
    }
}
