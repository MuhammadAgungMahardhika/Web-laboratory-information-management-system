<?php

namespace App\Filament\Clusters\MasterLocation;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class MasterLocationCluster extends Cluster
{
    protected static ?int $navigationSort = 22;
    protected static ?string $navigationLabel = 'Master Lokasi';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
}
