<?php

namespace App\Filament\Resources\Samples\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SampleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('lab_job_item_id')
                    ->numeric(),
                TextEntry::make('collected_by_personel_id')
                    ->numeric(),
                TextEntry::make('received_by_personel_id')
                    ->numeric(),
                TextEntry::make('sample_code'),
                TextEntry::make('collection_date')
                    ->date(),
                TextEntry::make('collection_time')
                    ->time(),
                TextEntry::make('latitude'),
                TextEntry::make('longitude'),
                TextEntry::make('container_type'),
                TextEntry::make('container_quantity')
                    ->numeric(),
                TextEntry::make('sample_volume'),
                TextEntry::make('preservation_method'),
                TextEntry::make('received_date')
                    ->date(),
                TextEntry::make('received_time')
                    ->time(),
                TextEntry::make('status'),
                TextEntry::make('created_by'),
                TextEntry::make('updated_by'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
