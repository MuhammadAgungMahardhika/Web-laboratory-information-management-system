<?php

namespace App\Services;

use App\Models\LabJob;
use App\Models\LabJobItem;
use App\Models\Parameter;
use App\Models\ParameterLabJobItem;
use Illuminate\Support\Collection;

class LabJobItemService
{
    /**
     * Generate kode Produk Uji.
     *
     * Example:
     * LAB-JLI-26070001-01
     * LAB-JLI-26070001-02
     */
    public function generateCode(LabJob $labJob): string
    {
        $lastCode = $labJob->labJobItems()
            ->latest('id')
            ->value('code');

        if (! $lastCode) {
            $sequence = 1;
        } else {
            preg_match(
                '/-(\d+)$/',
                $lastCode,
                $matches
            );

            $sequence = isset($matches[1])
                ? ((int) $matches[1]) + 1
                : 1;
        }
        return sprintf(
            '%s-%02d',
            $labJob->code,
            $sequence
        );
    }


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
                'parameter_code' => $parameter->code,
                'parameter_unit' => $parameter->unit,
                'parameter_price' => $parameter->default_price,
                'parameter_test_method_name' => $parameter->testMethod?->name,
                'parameter_standard_notes' => $parameter->standard_notes,
                'parameter_description' => $parameter->description,
                'parameter_status' => $parameter->status,
            ]);
        }
    }
}
