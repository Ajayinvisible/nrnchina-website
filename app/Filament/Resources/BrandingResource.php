<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandingResource\Pages;
use App\Filament\Resources\BrandingResource\RelationManagers;
use App\Models\Branding;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandingResource extends Resource
{
    protected static ?string $model = Branding::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company Logo & Copy Right')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')->required()
                            ->relationship('company', 'name')
                            ->default(fn() => Company::query()->value('id'))
                            ->columnSpanfull()
                            ->required(),
                        FileUpload::make('logo')
                            ->required()
                            ->directory('branding')
                            ->maxSize(2048) // in KB
                            ->image()
                            ->rules(['mimes:jpg,jpeg,png,gif']), // ✅ Correct way

                        FileUpload::make('favicon')
                            ->required()
                            ->directory('branding')
                            ->maxSize(1024) // in KB
                            ->image()
                            ->rules(['mimes:jpg,jpeg,png,gif']), // ✅ Correct way

                        TextInput::make('copy_right')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('logo'),
                ImageColumn::make('favicon'),
                TextColumn::make('copy_right'),
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
            'index' => Pages\ListBrandings::route('/'),
            'create' => Pages\CreateBranding::route('/create'),
            'edit' => Pages\EditBranding::route('/{record}/edit'),
        ];
    }
}
