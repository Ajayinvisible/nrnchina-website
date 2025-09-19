<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Register Menu')
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent Menu')
                            ->options(self::getNestedMenuOptions())
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(60)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) {
                                if ($operation == 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->required()
                            ->rules('string|max:60'),

                        TextInput::make('slug')->unique(ignoreRecord: true)->required(),

                        Select::make('position')
                            ->required()
                            ->options([
                                'main' => 'Main Menu',
                                'footer' => 'Footer Links'
                            ]),

                        TextInput::make('order')
                            ->nullable()
                            ->default(0)
                            ->numeric(),

                        Toggle::make('status')
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('indented_name') // Replaces raw name
                    ->label('Menu')
                    ->sortable(query: fn($query, $direction) => $query->orderBy('title', $direction))
                    ->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('order')->sortable(),
                ToggleColumn::make('status')->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }

    public static function getNestedMenuOptions($parentId = null, $prefix = ''): array
    {
        $menus = Menu::where('parent_id', $parentId)->get();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->id] = $prefix . $menu->title;
            $children = self::getNestedMenuOptions($menu->id, $prefix . '- ');
            $options += $children;
        }

        return $options;
    }
}
