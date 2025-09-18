<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Company;
use App\Models\Contact;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-down-left';

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
                        TextInput::make('number')
                            ->required()
                            ->maxLength(15)
                            ->regex('/^[0-9+\-\s]+$/'),
                        Select::make('type')
                            ->required()
                            ->options([
                                'phone' => 'Phone',
                                'support' => 'Support',
                                'viber' => 'Viber',
                                'whatsapp' => 'Whatsapp'
                            ]),
                        Toggle::make('status')
                            ->default(false)
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('number')->searchable()->sortable(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
