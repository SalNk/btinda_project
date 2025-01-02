<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DeliveryResource;

class ListDeliveries extends ListRecords
{
    protected static string $resource = DeliveryResource::class;
    protected ?string $heading = "Les livraisons";

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Toutes'),
            'Livrées' => Tab::make()->query(fn($query) => $query->whereRelation('order', 'status', 'delivered')),
            'Annulées' => Tab::make()->query(fn($query) => $query->whereRelation('order', 'status', 'cancelled')),
        ];
    }
}
