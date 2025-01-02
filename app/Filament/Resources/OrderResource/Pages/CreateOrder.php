<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    protected ?string $heading = 'Ajouter un BTinda';

    // public function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd(Order::create($data));
    // }

}
