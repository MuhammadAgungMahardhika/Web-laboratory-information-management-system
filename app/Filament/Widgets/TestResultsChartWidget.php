<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TestResultsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Test Results Chart Widget';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
