<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'BTinda';
    protected static ?string $label = 'BTinda';
    protected static ?string $navigationIcon = 'carbon-order-details';
    protected static ?string $navigationBadgeTooltip = 'Nouveaux BTinda';
    protected static ?int $navigationSort = 1;

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
                Section::make('Attribution')
                    ->visible(Auth::user()->role === 'admin')
                    ->schema([
                        Select::make('seller_id')
                            ->label('Vendeur')
                            ->relationship('seller', 'id')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? 'N/A')
                            ->columnSpanFull()
                            ->default(fn() => optional(Auth::user()->seller)->id),
                        Select::make('delivery_man_id')
                            ->label('Livreur')
                            ->relationship('delivery_man', 'id', function ($query) {
                                $query->where('is_available', true)
                                    ->whereHas('user', fn($q) => $q->where('is_active', true));
                            })
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? 'N/A')
                            ->columnSpanFull(),
                    ]),
                Section::make('Détail de la livraison')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Produit')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        TextInput::make('item_price')
                            ->label('Prix du produit')
                            ->columnSpan(1)
                            ->suffix('Fc')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        TextInput::make('delivery_price')
                            ->label('Frais de livraison')
                            ->suffix('Fc')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        TextInput::make('delivery_address')
                            ->label('Adresse de livraison')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        DatePicker::make('delivery_date')
                            ->label('Date de la livraison')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        TimePicker::make('delivery_time')
                            ->label('Heure de la livraison')
                            ->disabled(fn(Page $livewire): bool => $livewire instanceof EditRecord),
                        Select::make('status')
                            ->label('Statut')
                            ->options([
                                'new' => 'Nouvelle',
                                'processing' => 'En cours',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée'
                            ]),
                    ]),
                Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('media')
                            ->collection('BTinda-images')
                            ->multiple()
                            ->maxFiles(2)
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
                Section::make()
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('BTinda-images')
                    ->label('Images')
                    ->collection('BTinda-images'),
                TextColumn::make('seller.user.name')
                    ->label('Vendeur')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Produit')
                    ->limit(20)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('item_price')
                    ->label('Prix')
                    ->sortable()
                    ->searchable()
                    ->suffix(' Fc'),
                TextColumn::make('delivery_price')
                    ->label('Frais de livraison')
                    ->sortable()
                    ->searchable()
                    ->suffix(' Fc'),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
