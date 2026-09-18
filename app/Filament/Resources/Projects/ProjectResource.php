<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use App\Support\Media;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static ?string $navigationLabel = 'Projecten';

    protected static ?string $modelLabel = 'project';

    protected static ?string $pluralModelLabel = 'projecten';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

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
                    ->maxLength(255),
                TextInput::make('date_label')
                    ->label('Datumlabel')
                    ->helperText('Bv. JULI 2025'),
                DatePicker::make('date')
                    ->label('Datum')
                    ->native(false),
                Textarea::make('excerpt')
                    ->label('Korte tekst')
                    ->rows(3)
                    ->columnSpanFull(),
                MarkdownEditor::make('body')
                    ->label('Inhoud')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Hoofdfoto')
                    ->image()
                    ->disk('media')
                    ->directory('projecten')
                    ->visibility('public')
                    ->maxSize(Media::MAX_UPLOAD_KB),
                FileUpload::make('images')
                    ->label('Galerie')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('media')
                    ->directory('projecten')
                    ->visibility('public')
                    ->maxSize(Media::MAX_UPLOAD_KB)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('date', 'desc')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->disk('media'),
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('date_label')
                    ->label('Wanneer'),
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('Y-m')
                    ->sortable(),
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
