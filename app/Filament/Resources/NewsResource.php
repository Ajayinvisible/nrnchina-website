<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
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

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationGroup = 'News, Events & Projects';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

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

                                // Left Side → Short Description
                                RichEditor::make('short_description')
                                    ->nullable()
                                    ->columnSpan(1), // 👈 force to 1 column instead of full width

                                DatePicker::make('date')
                                    ->required(),

                                RichEditor::make('description')
                                    ->nullable()
                                    ->columnSpanFull(),

                                FileUpload::make('thumbnail')
                                    ->nullable()
                                    ->image()
                                    ->directory('projects')
                                    ->maxSize(2048)
                                    ->imageEditor()
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

                        Tab::make('Project Images')
                            ->icon('heroicon-o-photo')
                            ->iconPosition(IconPosition::Before)
                            ->schema([
                                FileUpload::make('images')
                                    ->label('Gallery Images')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->directory('ProjectGallery')
                                    ->columnSpanFull(),
                            ])

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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
