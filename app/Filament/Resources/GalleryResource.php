<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
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
use Illuminate\Support\Str;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Gallery')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) {
                                if ($operation == 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->required()
                            ->rules('string|max:50'),

                        TextInput::make('slug')->unique(ignoreRecord: true)->required(),

                        Textarea::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->nullable()
                            ->string()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('meta_description')
                            ->label('Meta Description | 160 character')
                            ->nullable()
                            ->string()
                            ->maxLength(160)
                            ->columnSpanFull(),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->reorderable()
                            ->directory('galleries')
                            ->rules(['mimes:png,jpg,jpeg,gif,webp'])
                            ->columnSpanFull(),

                        FileUpload::make('images')
                            ->label('Gallery Images')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->directory('galleries')
                            ->columnSpanFull(),

                        Toggle::make('status')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('thumbnail'),
                TextColumn::make('title')->sortable()->searchable(),
                ToggleColumn::make('status'),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
