<?php

namespace App\Services;

use App\Models\QuotationItem;
use App\Models\Parameter;
use App\Models\QuotationItemParameter;
use Illuminate\Support\Collection;

class QuotationItemService
{
    /**
     * Menangani sinkronisasi parameter untuk QuotationItem.
     *
     * @param QuotationItem $quotationItem
     * @return void
     */
    public function syncQuotationItemParameters(QuotationItem $quotationItem): void
    {
        $parameterIds = $quotationItem->parameters()->allRelatedIds() ?? [];

        if (empty($parameterIds)) {
            return;
        }

        // Hapus semua relasi pivot yang ada untuk menghindari duplikasi atau data lama
        $quotationItem->parameters()->detach();

        $parameters = Parameter::whereIn('id', $parameterIds)->with('testMethod')->get();

        foreach ($parameters as $parameter) {
            QuotationItemParameter::create([
                'quotation_item_id' => $quotationItem->id,
                'parameter_id' => $parameter->id,
                'parameter_name' => $parameter->name,
                'parameter_unit' => $parameter->unit,
                'parameter_default_test_method_name' => $parameter->testMethod?->name,
                'parameter_description' => $parameter->description,
                'parameter_status' => $parameter->status,
            ]);
        }
    }
}
