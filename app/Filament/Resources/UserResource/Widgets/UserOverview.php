<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListUsers::class;
    }
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total des vendeurs', $this->getPageTableQuery()->where('role', 'seller')->count()),
            Stat::make('Total des livreurs', $this->getPageTableQuery()->where('role', 'delivery_man')->count()),
            Stat::make('Utilisateurs actifs', $this->getPageTableQuery()->where('is_active', 1)->count()),
            Stat::make('Utilisateurs non actifs', $this->getPageTableQuery()->where('is_active', 0)->count()),
        ];
    }
}
