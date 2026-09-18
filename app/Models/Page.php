<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'body'])]
class Page extends Model
{
    public function isLocked(): bool
    {
        return in_array($this->slug, ['origin-story', 'voorwaarden'], true);
    }
}
