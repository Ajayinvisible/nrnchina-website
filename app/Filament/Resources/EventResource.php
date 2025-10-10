<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'News, Events & Projects';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Add Project Details')
                    ->tabs([
                        Tab::make('Project Details')
                            ->icon('heroicon-o-identification')
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
                                    ->rules('string|max:50'),

                                TextInput::make('slug')
                                    ->unique(ignoreRecord: true)
                                    ->required(),

                                DatePicker::make('date')
                                    ->required(),

                                TextInput::make('location')
                                    ->nullable()
                                    ->maxLength(255),

                                // Left Side → Short Description
                                RichEditor::make('short_description')
                                    ->nullable()
                                    ->columnSpan(1),

                                FileUpload::make('thumbnail')
                                    ->nullable()
                                    ->image()
                                    ->directory('projects')
                                    ->maxSize(2048)
                                    ->imageEditor(),

                                RichEditor::make('description')
                                    ->nullable()
                                    ->columnSpanFull(),

                                Toggle::make('status'),
                            ])->columns(2),

                        Tab::make('SEO Description')
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
                            ]),

                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
