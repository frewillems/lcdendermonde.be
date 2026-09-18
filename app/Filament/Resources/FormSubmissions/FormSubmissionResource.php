<?php

namespace App\Filament\Resources\FormSubmissions;

use App\Filament\Resources\FormSubmissions\Pages\ListFormSubmissions;
use App\Filament\Resources\FormSubmissions\Pages\ViewFormSubmission;
use App\Models\FormSubmission;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Berichten';

    protected static ?string $modelLabel = 'bericht';

    protected static ?string $pluralModelLabel = 'berichten';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => $state === 'join' ? 'Lid worden' : 'Contact'),
                TextEntry::make('name')
                    ->label('Naam'),
                TextEntry::make('email')
                    ->label('E-mail'),
                TextEntry::make('created_at')
                    ->label('Ontvangen')
                    ->dateTime('d/m/Y H:i'),
                TextEntry::make('payload')
                    ->label('Inhoud')
                    ->formatStateUsing(fn ($state): string => collect($state ?? [])
                        ->map(fn ($value, $key) => $key.': '.(is_scalar($value) ? $value : json_encode($value)))
                        ->implode("\n"))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'join' ? 'Lid worden' : 'Contact'),
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Ontvangen')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormSubmissions::route('/'),
            'view' => ViewFormSubmission::route('/{record}'),
        ];
    }
}
