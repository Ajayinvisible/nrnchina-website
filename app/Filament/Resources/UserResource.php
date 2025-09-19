<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Create User & Member')->tabs([
                    Tab::make('User Infrormation')
                        ->icon('heroicon-o-identification')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(100),

                            Select::make('status')
                                ->options([
                                    'pending' => 'Pending',
                                    'inactive' => 'Inactive',
                                    'active' => 'Active'
                                ])
                                ->default('pending')
                                ->required(),

                            TextInput::make('email')
                                ->required()
                                ->email()
                                ->unique(
                                    table: 'users',
                                    column: 'email',
                                    ignorable: fn($record) => $record
                                )
                                ->maxLength(100)
                                ->columnSpanFull(),

                            TextInput::make('phone')
                                ->nullable()
                                ->maxLength(15)
                                ->regex('/^[0-9+\-\s]+$/') // only numbers, +, -, spaces allowed
                                ->columnSpanFull(),

                            TextInput::make('password')
                                ->required()
                                ->password()
                                ->default('Nrnchina@01') // 👈 default password
                                ->dehydrated(fn($state) => filled($state)) // only save if filled
                                ->hiddenOn('edit') // 👈 only show on create
                                ->afterStateHydrated(fn($component, $state) => $component->state('')), // clear when editing

                            TextInput::make('password_confirmation')
                                ->required()
                                ->password()
                                ->label('Confirm Password')
                                ->dehydrated(false) // never save
                                ->hiddenOn('edit'), // 👈 only show on create

                            FileUpload::make('profile')
                                ->label('Profile Image')
                                ->nullable()
                                ->image()
                                ->directory('breadcrumb') // 👈 save in storage/app/public/user
                                ->maxSize(2048) // 2MB max
                                ->imageEditor()
                                ->rules(['mimes:jpg,jpeg,png,gif'])
                                ->columnSpanFull(),
                        ])->columns(2)
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('profile'),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => [
                        'active'   => 'Active',
                        'inactive' => 'Inactive',
                        'pending'  => 'Pending',
                    ][$state] ?? $state)
                    ->color(fn($state) => match ($state) {
                        'active'   => 'success',
                        'inactive' => 'danger',
                        'pending'  => 'warning',
                        default    => 'gray',
                    })->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}
