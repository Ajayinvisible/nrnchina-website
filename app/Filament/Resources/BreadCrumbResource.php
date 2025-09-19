<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BreadCrumbResource\Pages;
use App\Filament\Resources\BreadCrumbResource\RelationManagers;
use App\Models\BreadCrumb;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BreadCrumbResource extends Resource
{
    protected static ?string $model = BreadCrumb::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Bread Crumb')
                    ->schema([
                        Select::make('menu_id')
                            ->label('Bread Crumb According Menu')
                            ->required()
                            ->relationship('menu', 'title')
                            ->searchable()
                            ->preload(),
                        FileUpload::make('image')
                            ->label('Bread Crumb Image')
                            ->nullable()
                            ->image()
                            ->directory('user') // 👈 save in storage/app/public/user
                            ->maxSize(2048) // 2MB max
                            ->imageEditor()
                            ->rules(['mimes:jpg,jpeg,png,gif'])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('menu.title')->sortable()->searchable(),
                ImageColumn::make('image'),
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
            'index' => Pages\ListBreadCrumbs::route('/'),
            'create' => Pages\CreateBreadCrumb::route('/create'),
            'edit' => Pages\EditBreadCrumb::route('/{record}/edit'),
        ];
    }
}
