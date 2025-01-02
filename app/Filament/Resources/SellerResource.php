<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Seller;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SellerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SellerResource\RelationManagers;
use App\Filament\Resources\SellerResource\RelationManagers\OrdersRelationManager;

class SellerResource extends Resource
{
    protected static ?string $model = Seller::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Vendeurs';
    protected static ?string $label = 'Vendeurs';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->role === 'seller' || Auth::user()->role === 'admin';
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
                            ->default('seller')
                    ]),
                Section::make()
                    ->schema([
                        TextInput::make('shop_name')
                            ->label('Nom de la boutique'),
                        TextInput::make('shop_address')
                            ->label('Adresse de la boutique'),
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
                TextColumn::make('shop_name')
                    ->label('Nom de la boutique')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shop_address')
                    ->label('Adresse de la boutique')
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
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSeller::route('/create'),
            'edit' => Pages\EditSeller::route('/{record}/edit'),
        ];
    }
}
