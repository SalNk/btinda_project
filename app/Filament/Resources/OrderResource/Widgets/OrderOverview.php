<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{

    use InteractsWithPageTable;

    public function getTablePage()
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('BTinda à faire', $this->getPageTableQuery()->where('status', 'new')->count()),
            Stat::make('BTinda en cours', $this->getPageTableQuery()->where('status', 'processing')->count()),
            Stat::make('BTinda effectués', $this->getPageTableQuery()->where('status', 'delivered')->count()),
        ];
    }
}
