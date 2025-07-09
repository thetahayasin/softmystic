<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Software;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DownloadsChart extends ChartWidget
{
    protected static ?string $heading = 'Downloads (Top 10)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get downloads grouped by software name for the last 7 days
        $downloads = Software::select('name', DB::raw('SUM(downloads) as total_downloads'))
            ->groupBy('name')
            ->orderByDesc('total_downloads')
            ->limit(10) // Optional: Limit to top 10 software
            ->get();

        $labels = $downloads->pluck('name')->toArray();
        $data = $downloads->pluck('total_downloads')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Downloads',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', '#6366f1', '#10b981', '#f59e0b',
                        '#ef4444', '#8b5cf6', '#ec4899', '#0ea5e9',
                        '#22c55e', '#eab308',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Use 'doughnut' or 'pie' for circular charts
    }

    public static function canView(): bool
    {
        return Auth::user()?->can('widget_DownloadsChart');
    }
}
