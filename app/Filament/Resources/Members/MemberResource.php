<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Models\Member;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Leden';

    protected static ?string $modelLabel = 'lid';

    protected static ?string $pluralModelLabel = 'leden';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->disk('media')
                    ->directory('leden')
                    ->visibility('public')
                    ->imageResizeMode('cover')
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Naam')
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
                TextInput::make('role')
                    ->label('Functie')
                    ->maxLength(255),
                Select::make('group')
                    ->label('Groep')
                    ->options([
                        'bestuur' => 'Bestuur',
                        'lid' => 'Actief lid',
                        'seniorita' => 'Seniorita / erelid',
                        'in-memoriam' => 'In memoriam',
                    ])
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Volgorde')
                    ->numeric()
                    ->default(100)
                    ->helperText('Lager = hoger in de lijst. Bestuur: 1 = voorzitster.'),
                Textarea::make('bio')
                    ->label('Bio')
                    ->rows(6)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('photo')
                    ->label('')
                    ->disk('media')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Functie')
                    ->searchable(),
                TextColumn::make('group')
                    ->label('Groep')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'bestuur' => 'Bestuur',
                        'lid' => 'Lid',
                        'seniorita' => 'Seniorita',
                        'in-memoriam' => 'In memoriam',
                        default => $state,
                    }),
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
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }
}
