<?php

namespace App\Filament\Clusters\Master;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class MasterCluster extends Cluster
{
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Master Lab';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
}
