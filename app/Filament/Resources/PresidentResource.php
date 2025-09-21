<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresidentResource\Pages;
use App\Filament\Resources\PresidentResource\RelationManagers;
use App\Models\President;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PresidentResource extends Resource
{
    protected static ?string $model = President::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('President Message and Information')
                    ->tabs([
                        Tab::make("Message From President")
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->iconPosition(IconPosition::Before)
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

                                TextInput::make('name')
                                    ->label('President Name')
                                    ->required()
                                    ->maxLength(100),

                                Textarea::make('slogan')
                                    ->label('Slogan Form President')
                                    ->nullable(),

                                RichEditor::make('description')
                                    ->columnSpanFull(),

                                TextInput::make('office_contact')
                                    ->label('Office Contact')
                                    ->required()
                                    ->maxLength(15)
                                    ->regex('/^[0-9+\-\s]+$/'),

                                TextInput::make('office_location')
                                    ->label('Office Location')
                                    ->required(),

                                FileUpload::make('image')
                                    ->nullable()
                                    ->image()
                                    ->directory('president')
                                    ->maxSize(2048) // 2MB max
                                    ->imageEditor()
                                    ->rules(['mimes:jpg,jpeg,png,gif'])
                                    ->columnSpanFull(),

                            ])->columns(2),
                        Tab::make('SEO Content')
                            ->icon('heroicon-o-presentation-chart-line')
                            ->iconPosition(IconPosition::Before)
                            ->schema([
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
                            ])
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('office_contact'),
                TextColumn::make('office_location'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    
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
            'index' => Pages\ListPresidents::route('/'),
            'create' => Pages\CreatePresident::route('/create'),
            'edit' => Pages\EditPresident::route('/{record}/edit'),
        ];
    }
}
