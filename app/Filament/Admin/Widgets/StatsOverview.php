<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Locale;
use App\Models\Software;
use App\Models\SoftwareTranslation;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '15s';

    protected static bool $isLazy = true;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {

        $softwareChart = $this->getDailyCounts(Software::class);
        $localeChart   = $this->getDailyCounts(Locale::class);
        $translation   = $this->getDailyCounts(SoftwareTranslation::class);
        $categoryChart = $this->getDailyCounts(Category::class);

        return [
            Stat::make('Total Softwares', Software::count())
            ->description('Software listed on website')
            ->chart($softwareChart)
            ->color('success'),

            Stat::make('Total Languages', Locale::count())
            ->description('Languages website is offered in')
            ->chart($localeChart)
            ->color('info'),

            Stat::make('Content Translations', SoftwareTranslation::count())
            ->description('Translations of software reviews')
            ->chart($translation)

            ->color('warning'),

            Stat::make('Total Categories', Category::count())
            ->description('Number of Categories')
            ->chart($categoryChart)

            ->color('danger')
        ];
    }

    private function getDailyCounts(string $model): array
    {
        $counts = $model::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('count', 'date')
            ->all();
    
        return collect(range(0, 6))
            ->map(function ($i) use ($counts) {
                $date = Carbon::today()->subDays(6 - $i)->format('Y-m-d');
                return $counts[$date] ?? 0;
            })
            ->toArray();
    }
}
