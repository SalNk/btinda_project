<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class ListOrders extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = OrderResource::class;
    protected ?string $heading = 'Liste des BTinda';

    protected function getHeaderActions(): array
    {
        if (Auth::user()->role === 'delivery_man') {
            return [];
        }
        return [
            Actions\CreateAction::make(),
        ];

    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Toutes'),
            'Nouvelles' => Tab::make()->query(fn($query) => $query->where('status', 'new')),
            'En cours' => Tab::make()->query(fn($query) => $query->where('status', 'processing')),
            'Livrées' => Tab::make()->query(fn($query) => $query->where('status', 'delivered')),
            'Annulées' => Tab::make()->query(fn($query) => $query->where('status', 'cancelled')),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class
        ];
    }
}
