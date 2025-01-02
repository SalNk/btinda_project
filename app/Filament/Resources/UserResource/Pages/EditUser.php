<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Seller;
use App\Models\DeliveryMan;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected ?string $heading = "Editer un utilisateur";

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($data['role'] !== $record->role) {
            if ($data['role'] == 'seller') {
                Seller::create([
                    'user_id' => $record->id,
                    'shop_name' => $data['shop_name'],
                    'shop_address' => $data['shop_address'],
                ]);

                DeliveryMan::where('user_id', $record->id)->delete();
            } elseif ($data['role'] == 'delivery_man') {

                DeliveryMan::create([
                    'user_id' => $record->id,
                    'is_available' => 1,
                ]);

                Seller::where('user_id', $record->id)->delete();
            } else {

                Seller::where('user_id', $record->id)->delete();
                DeliveryMan::where('user_id', $record->id)->delete();
            }
        }

        $record->update($data);

        return $record;
    }
}
