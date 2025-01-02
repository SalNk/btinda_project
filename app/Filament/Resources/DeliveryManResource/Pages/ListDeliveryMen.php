<?php

namespace App\Filament\Resources\DeliveryManResource\Pages;

use App\Filament\Resources\DeliveryManResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryMen extends ListRecords
{
    protected static string $resource = DeliveryManResource::class;
    protected ?string $heading = "Liste des livreurs";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
