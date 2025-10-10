<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSliderResource\Pages;
use App\Filament\Resources\HeroSliderResource\RelationManagers;
use App\Models\HeroSlider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSliderResource extends Resource
{
    protected static ?string $model = HeroSlider::class;

    protected static ?string $navigationGroup = 'Hero Slider & breadcrumb';

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Home Page Hero SLider')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Textarea::make('text')
                            ->label('Short Description')
                            ->nullable()
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Hero Image')
                            ->image()
                            ->directory('hero')
                            ->maxSize(2048) // 2MB max
                            ->imageEditor()
                            ->rules(['mimes:jpg,jpeg,png,gif'])
                            ->columnSpanFull(),

                        Toggle::make('status')
                            ->default(true)

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('image')->sortable(),
                TextColumn::make('title')->sortable()->searchable(),
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
            'index' => Pages\ListHeroSliders::route('/'),
            'create' => Pages\CreateHeroSlider::route('/create'),
            'edit' => Pages\EditHeroSlider::route('/{record}/edit'),
        ];
    }
}
