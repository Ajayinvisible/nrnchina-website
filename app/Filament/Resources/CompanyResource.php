<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Company Details')
                    ->tabs([
                        Tab::make('Company Info')
                            ->icon('heroicon-o-information-circle')
                            ->iconPosition(IconPosition::Before)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Company Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('email')
                                    ->label('Company Email')
                                    ->required()
                                    ->email()
                                    ->maxLength(100),

                                TextInput::make('address')
                                    ->label('Company Address')
                                    ->required()
                                    ->maxLength(160),

                                RichEditor::make('short_description')
                                    ->label('Company Short Description')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Tab::make('Company Meta Description')
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->iconPosition(IconPosition::Before)
                            ->schema([
                                TextArea::make('meta_keywords')
                                    ->nullable()
                                    ->maxLength(200),
                                Textarea::make('meta_description')
                                    ->nullable()
                                    ->maxLength(160)
                            ]),
                        Tab::make('Company Embed Google Map')
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->iconPosition(IconPosition::Before)
                            ->schema([
                                TextArea::make('google_map')
                                    ->label('Embed Google Map')
                                    ->nullable(),
                            ])
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('address'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
