<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    protected ?string $heading = 'Ajouter un bitinda';

    // public function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd($data);
    // }

}
