<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Software;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DownloadsChart extends ChartWidget
{
    protected static ?string $heading = 'Downloads in Last 7 Days';

    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $downloadsByDay = Software::select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('SUM(downloads) as total_downloads')
            )
            ->where('updated_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total_downloads', 'date')
            ->toArray();

        $dates = collect(range(0, 6))
            ->map(fn ($i) => Carbon::today()->subDays(6 - $i))
            ->mapWithKeys(fn ($date) => [$date->format('Y-m-d') => $date->format('D')]);

        $downloads = $dates->keys()->map(fn ($date) => $downloadsByDay[$date] ?? 0)->toArray();
        $labels = $dates->values()->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Downloads',
                    'data' => $downloads,
                    'fill' => true,
                    'borderColor' => '#3b82f6', // Tailwind primary blue
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return Auth::user()?->can('widget_DownloadsChart');
    }
}
