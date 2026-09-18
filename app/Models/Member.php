<?php

namespace App\Models;

use App\Support\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'name', 'role', 'bio', 'photo', 'group', 'sort_order'])]
class Member extends Model
{
    /**
     * @return array<string, mixed>
     */
    public function toSiteArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'role' => $this->role,
            'bio' => $this->bio,
            'photo' => Media::url($this->photo),
            'group' => $this->group,
        ];
    }
}
