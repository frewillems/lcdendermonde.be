<?php

namespace App\Filament\Resources\SiteEvents\Pages;

use App\Filament\Resources\SiteEvents\SiteEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteEvent extends CreateRecord
{
    protected static string $resource = SiteEventResource::class;
}
