<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialResource\Pages;
use App\Filament\Resources\SocialResource\RelationManagers;
use App\Models\Company;
use App\Models\Social;
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

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

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
                            ->required(),

                        TextInput::make('icon')
                            ->nullable()
                            ->maxLength(100)
                            ->label(function () {
                                return new \Illuminate\Support\HtmlString(
                                    'Icon <a href="https://fontawesome.com/search?q=phone&ic=free&o=r" target="_blank" class="text-primary underline">(Browse Icons)</a>'
                                );
                            })
                            ->placeholder('e.g. fa-solid fa-user'),

                        TextInput::make('link')
                            ->label('Social Media Link')
                            ->required()
                            ->url()
                            ->maxLength(255),

                        TextInput::make('platform')
                            ->label('Social Media Platform Name')
                            ->required()
                            ->maxLength(100),

                        Toggle::make('status')
                            ->default(false)
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(
                        fn($state) => $state
                            ? "<i class='{$state} text-xl mr-2'></i> || {$state}"
                            : '-'
                    )
                    ->html(),
                TextColumn::make('platform')->sortable()->searchable(),
                ToggleColumn::make('status')
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
            'index' => Pages\ListSocials::route('/'),
            'create' => Pages\CreateSocial::route('/create'),
            'edit' => Pages\EditSocial::route('/{record}/edit'),
        ];
    }
}
