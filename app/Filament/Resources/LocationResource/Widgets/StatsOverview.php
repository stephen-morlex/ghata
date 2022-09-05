<?php

namespace App\Filament\Resources\LocationResource\Widgets;

use App\Models\Location;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {

        return [
            Card::make('LOCATION', Location::count())
                ->description('Total number of location')
                ->descriptionIcon('heroicon-o-location-marker')
                ->color('success'),
        ];
    }
}
