<?php

namespace App\Filament\Clusters\MasterGeneral;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class MasterGeneralCluster extends Cluster
{
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Master Umum';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
}
