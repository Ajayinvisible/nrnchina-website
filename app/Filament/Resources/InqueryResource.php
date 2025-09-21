<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InqueryResource\Pages;
use App\Filament\Resources\InqueryResource\RelationManagers;
use App\Models\Inquery;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InqueryResource extends Resource
{
    protected static ?string $model = Inquery::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('All Inquery Form Site')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'complected' => 'Complected'
                            ])
                            ->columnSpanFull(),

                        TextInput::make('name'),
                        TextInput::make('email'),
                        TextInput::make('phone'),
                        TextInput::make('subject'),
                        Textarea::make('message')
                        ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('subject')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListInqueries::route('/'),
            'create' => Pages\CreateInquery::route('/create'),
            'edit' => Pages\EditInquery::route('/{record}/edit'),
        ];
    }
}
