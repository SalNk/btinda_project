<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryMan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeliveryManResource\Pages;
use App\Filament\Resources\DeliveryManResource\RelationManagers;
use App\Filament\Resources\DeliveryManResource\RelationManagers\OrdersRelationManager;

class DeliveryManResource extends Resource
{
    protected static ?string $model = DeliveryMan::class;
    protected static ?string $navigationIcon = 'carbon-delivery';
    protected static ?string $navigationLabel = 'Livreurs';
    protected static ?string $label = 'Livreurs';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role === 'delivery_man' || Auth::user()->role === 'admin';
    }

    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->role === 'delivery_man') {
            return static::getModel()::query()->where('user_id', Auth::id());
        } elseif (Auth::user()->role === 'admin') {
            return static::getModel()::query();
        } else {
            return static::getModel()::query()->where('id', 0);
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identité')
                    ->relationship('user')
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
                        Select::make('role')
                            ->visible(false)
                            ->options([
                                'admin' => 'Administrateur',
                                'seller' => 'Vendeur',
                                'delivery_man' => 'Livreur',
                            ])
                            ->default('delivery_man')
                    ]),
                Section::make('Disponibilité du livreur')
                    ->schema([
                        Select::make('is_available')
                            ->label('Disponibilité')
                            ->options([1 => 'Disponible', 0 => 'Indisponible'])
                            ->default(1)
                            ->reactive(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.avatar')
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('user.name')
                    ->label('Nom complet')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_available')
                    ->label('Disponibilité')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(int $state) => match ($state) {
                        1 => 'success',
                        0 => 'warning',
                    })
                    ->formatStateUsing(fn($state) => $state ? 'Disponible' : 'Non disponible'),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.telephone')
                    ->label('Téléphone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.address')
                    ->label('Adresse')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
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
            OrdersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryMen::route('/'),
            'create' => Pages\CreateDeliveryMan::route('/create'),
            'edit' => Pages\EditDeliveryMan::route('/{record}/edit'),
        ];
    }
}
