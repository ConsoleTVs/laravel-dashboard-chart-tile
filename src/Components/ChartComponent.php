<?php

namespace Fidum\ChartTile\Components;

use Fidum\ChartTile\Charts\DefaultChart;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ChartComponent extends Component
{
    public string $chartClass;

    public array $chartFilters;

    public string $height;

    public string $position;

    public int $refreshIntervalInSeconds;

    public function mount(
        string $position = '',
        string $height = '100%',
        string $chartClass = null,
        array $chartFilters = [],
        int $refreshIntervalInSeconds = null
    ): void {
        $this->height = $height;
        $this->position = $position;
        $this->chartFilters = $chartFilters;
        $this->chartClass = $chartClass ?? DefaultChart::class;

        Request::merge($this->chartFilters);

        $this->refreshIntervalInSeconds = $refreshIntervalInSeconds
            ?? config('dashboard.tiles.charts.refresh_interval_in_seconds', 300);
    }

    /** @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View*/
    public function render()
    {
        return view('dashboard-chart-tiles::tile', [
            'wireId' => $this->id,
            'chart' => app($this->chartClass),
        ]);
    }
}
