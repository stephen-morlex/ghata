<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use App\Filament\Resources\LocationResource\Widgets\LocationOverview;
use App\Filament\Resources\LocationResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class
        ];
    }
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
