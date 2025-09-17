<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Resources\TeamMemberResource\RelationManagers;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User & Team Group')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->required()
                            ->relationship('user', 'name') // 👈 relationship method on the model
                            ->searchable() // optional
                            ->preload(),   // optional, loads all

                        Select::make('member_group_id')
                            ->label('Member Group')
                            ->required()
                            ->relationship('memberGroup', 'name') // 👈 relationship method on the model
                            ->searchable()
                            ->preload(),

                        DatePicker::make('dob')
                            ->label('Date of birth')
                            ->required(),

                        TextInput::make('father_name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('designation')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('occupation')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('nationality')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull()
                            ->default('Neplese'),

                        TextInput::make('address_nepal')
                            ->required()
                            ->maxLength(160),

                        TextInput::make('address_china')
                            ->required()
                            ->maxLength(160),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->sortable()->searchable(),
                TextColumn::make('memberGroup.name')->sortable()->searchable(),
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
