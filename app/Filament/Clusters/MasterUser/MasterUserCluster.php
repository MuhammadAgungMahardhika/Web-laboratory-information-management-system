<?php

namespace App\Filament\Clusters\MasterUser;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class MasterUserCluster extends Cluster
{
    protected static ?int $navigationSort = 23;
    protected static ?string $navigationLabel = 'Master Pengguna';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
}
