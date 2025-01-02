<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestion d\'utilisateurs';
    protected static ?string $navigationLabel = 'Utilisateurs';
    protected static ?string $label = 'Utilisateurs';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        FileUpload::make('avatar')
                            ->image()
                    ]),
                Section::make('Identité')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom complet')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('telephone')
                            ->required()
                            ->maxLength(20)
                            ->label('Téléphone'),
                        TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->label('Adresse'),
                    ]),
                Section::make('Permissions')
                    ->schema([
                        Select::make('role')
                            ->options([
                                'admin' => 'Administrateur',
                                'seller' => 'Vendeur',
                                'delivery_man' => 'Livreur',
                            ])
                            ->default('delivery_man')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $get) => $get('role')),
                        Select::make('is_active')
                            ->label('Active')
                            ->options([1 => 'Actif', 0 => 'Non actif'])
                            ->default(1),
                    ]),
                Section::make()
                    ->visible(fn(callable $get) => $get('role') === 'seller')
                    ->schema([
                        TextInput::make('shop_name')
                            ->label('Nom de la boutique'),
                        TextInput::make('shop_address')
                            ->label('Adresse de la boutique'),
                    ]),
                Section::make('Disponibilité du livreur')
                    ->visible(fn(callable $get) => $get('role') === 'delivery_man')
                    ->schema([
                        Select::make('is_available')
                            ->label('Disponibilité')
                            ->options([1 => 'Disponible', 0 => 'Indisponible'])
                            ->default(1)
                            ->reactive(),
                    ]),
                Section::make('Sécurité')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                        TextInput::make('password_confirmation')
                            ->label('Confirmation du mot de passe')
                            ->password()
                            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                            ->minLength(8)
                            ->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->circular(),
                TextColumn::make('name')->sortable()->searchable()
                    ->label('Nom'),
                TextColumn::make('email')->sortable()->searchable()
                    ->label('Email'),
                TextColumn::make('role')->sortable()->searchable()
                    ->label('Rôle')
                    ->formatStateUsing(function ($state) {
                        $translations = [
                            'admin' => "Administrateur",
                            'seller' => "Vendeur",
                            'delivery_man' => "Livreur"
                        ];

                        return $translations[$state] ?? $state;
                    }),
                TextColumn::make('created_at')->dateTime()
                    ->label('Créé le')
                    ->date('D d-m-Y'),
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
}
