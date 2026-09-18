<?php

namespace App\Filament\Resources\SiteEvents\Pages;

use App\Filament\Resources\SiteEvents\SiteEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteEvents extends ListRecords
{
    protected static string $resource = SiteEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
