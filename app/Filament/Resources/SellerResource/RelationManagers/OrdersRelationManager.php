<?php

namespace App\Filament\Resources\SellerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    protected static ?string $title = 'Le(s) BTinda du vendeur';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Produit')
                    ->limit(20)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('item_price')
                    ->label('Prix')
                    ->sortable()
                    ->searchable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money(),
                    ]),
                TextColumn::make('delivery_price')
                    ->label('Livraison')
                    ->sortable()
                    ->searchable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money(),
                    ]),
                TextColumn::make('delivery_date')
                    ->label('Date')
                    ->sortable()
                    ->searchable()
                    ->date('D d M Y'),
                TextColumn::make('delivery_time')
                    ->label('Heure')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('delivery_man.user.name')
                    ->label('Livreur')
                    ->sortable()
                    ->searchable()
                    ->limit(15),
                TextColumn::make('status')
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
                        'cancelled' => 'danger'
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
