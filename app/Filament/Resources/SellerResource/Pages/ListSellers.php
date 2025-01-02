<?php

namespace App\Filament\Resources\SellerResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SellerResource;

class ListSellers extends ListRecords
{
    protected static string $resource = SellerResource::class;
    protected ?string $heading = "La liste des vendeurs";

    protected function getHeaderActions(): array
    {
        return Auth::user()->role === 'admin'
            ? [
                Actions\CreateAction::make(),
            ]
            : [];
    }

}
