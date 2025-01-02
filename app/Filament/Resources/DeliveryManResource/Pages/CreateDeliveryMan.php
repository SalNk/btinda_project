<?php

namespace App\Filament\Resources\DeliveryManResource\Pages;

use App\Filament\Resources\DeliveryManResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeliveryMan extends CreateRecord
{
    protected static string $resource = DeliveryManResource::class;
    protected ?string $heading = "Ajouter un livreur";
}
