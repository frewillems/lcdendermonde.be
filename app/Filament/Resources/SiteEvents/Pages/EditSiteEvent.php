<?php

namespace App\Filament\Resources\SiteEvents\Pages;

use App\Filament\Resources\SiteEvents\SiteEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteEvent extends EditRecord
{
    protected static string $resource = SiteEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
