<?php

namespace App\Services;

use App\Models\LabJobItem;
use App\Models\Parameter;
use App\Models\ParameterLabJobItem;
use Illuminate\Support\Collection;

class LabJobItemService
{
    /**
     * Menangani sinkronisasi parameter untuk LabJobItem.
     *
     * @param LabJobItem $labJobItem
     * @return void
     */
    public function syncParameterLabJobItems(LabJobItem $labJobItem): void
    {
        $parameterIds = $labJobItem->parameters()->allRelatedIds() ?? [];

        if (empty($parameterIds)) {
            return;
        }

        // Hapus semua relasi pivot yang ada untuk menghindari duplikasi atau data lama
        $labJobItem->parameters()->detach();

        $parameters = Parameter::whereIn('id', $parameterIds)->with('testMethod')->get();

        foreach ($parameters as $parameter) {
            ParameterLabJobItem::create([
                'lab_job_item_id' => $labJobItem->id,
                'parameter_id' => $parameter->id,
                'parameter_name' => $parameter->name,
                'parameter_unit' => $parameter->unit,
                'parameter_default_price' => $parameter->default_price,
                'parameter_default_test_method_name' => $parameter->testMethod?->name,
                'parameter_description' => $parameter->description,
                'parameter_status' => $parameter->status,
            ]);
        }
    }
}
