<?php

namespace App\Filament\Resources\SiteEvents;

use App\Filament\Resources\SiteEvents\Pages\CreateSiteEvent;
use App\Filament\Resources\SiteEvents\Pages\EditSiteEvent;
use App\Filament\Resources\SiteEvents\Pages\ListSiteEvents;
use App\Models\SiteEvent;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SiteEventResource extends Resource
{
    protected static ?string $model = SiteEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Evenementen';

    protected static ?string $modelLabel = 'evenement';

    protected static ?string $pluralModelLabel = 'evenementen';

    protected static ?string $slug = 'evenementen';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titel')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get): void {
                        if (blank($get('slug'))) {
                            $set('slug', Str::slug((string) $state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('URL: lcdendermonde.be/jouw-slug'),
                TextInput::make('date_label')
                    ->label('Datumlabel'),
                TextInput::make('related_album')
                    ->label('Gerelateerd album (slug)')
                    ->helperText('Optioneel, bv. fotoreportage-recharter'),
                MarkdownEditor::make('body')
                    ->label('Inhoud')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Hoofdfoto')
                    ->image()
                    ->disk('media')
                    ->directory('events')
                    ->visibility('public'),
                FileUpload::make('images')
                    ->label('Extra beelden')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('media')
                    ->directory('events')
                    ->visibility('public')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('date_label')
                    ->label('Wanneer'),
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListSiteEvents::route('/'),
            'create' => CreateSiteEvent::route('/create'),
            'edit' => EditSiteEvent::route('/{record}/edit'),
        ];
    }
}
