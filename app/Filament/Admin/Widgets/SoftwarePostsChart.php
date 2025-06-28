<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Software;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoftwarePostsChart extends ChartWidget
{
    protected static ?string $heading = 'Softwares Added in Last 7 Days';

    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $postsByDay = Software::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Generate 7-day range with labels
        $dates = collect(range(0, 6))
            ->map(fn ($i) => Carbon::today()->subDays(6 - $i))
            ->mapWithKeys(fn ($date) => [$date->format('Y-m-d') => $date->format('D')]);

        $counts = $dates->keys()->map(fn ($date) => $postsByDay[$date] ?? 0)->toArray();
        $labels = $dates->values()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Softwares Added',
                    'data' => $counts,
                    'fill' => true,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)', // Tailwind emerald-500 with opacity
                    'borderColor' => '#10b981', // emerald-500
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
