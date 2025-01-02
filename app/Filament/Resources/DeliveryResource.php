<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Delivery;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeliveryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeliveryResource\RelationManagers;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;
    protected static ?string $navigationLabel = 'Livraisons';
    protected static ?string $label = 'Livraisons';
    protected static ?string $navigationIcon = 'carbon-delivery-parcel';
    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        // Si l'utilisateur est un "seller", on filtre les deliveries associées à ce seller
        if ($userRole === 'seller') {
            return static::getModel()::query()
                ->whereHas('seller', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
        }

        // Si l'utilisateur est un "delivery man", on filtre les deliveries associées à ce delivery man
        if ($userRole === 'delivery_man') {
            return static::getModel()::query()
                ->whereHas('delivery_man', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
        }

        // Si l'utilisateur est un "admin", on affiche toutes les deliveries
        if ($userRole === 'admin') {
            return static::getModel()::query();
        }

        // Par défaut, ne retourner aucun enregistrement
        return static::getModel()::query()->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.name')
                    ->label('Livraison')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                TextColumn::make('delivery_man.user.name')
                    ->label('Livreur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('seller.user.name')
                    ->label('Vendeur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('order.status')
                    ->label('Statut')
                    ->formatStateUsing(function ($state) {
                        $translations = [
                            'new' => 'Nouvelle',
                            'processing' => 'En cours',
                            'delivered' => 'Livrée',
                            'cancelled' => 'Annulée'
                        ];
                        return $translations[$state] ?? $state;
                    })
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'new' => 'info',
                        'processing' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'warning'
                    }),
                TextColumn::make('delivery_date')
                    ->label('Date de livraison')
                    ->date('D d-m-Y')
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
