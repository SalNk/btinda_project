<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\Seller;
use App\Models\DeliveryMan;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected ?string $heading = "Créer un utilisateur";

    function handleRecordCreation(array $data): Model
    {
        $user = static::getModel()::create($data);

        if ($user['role'] == 'seller') {
            $seller = Seller::create([
                'user_id' => $user->id,
                'shop_name' => $data['shop_name'],
                'shop_address' => $data['shop_address'],
            ]);
        } else if ($user['role'] == 'delivery_man') {
            $delivery = DeliveryMan::create([
                'user_id' => $user->id,
                'is_available' => 1,
            ]);
        }

        return $user;
    }
}
