<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $incomes = Transaction::incomes()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');
        $outcomes = Transaction::expenses()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');
        $diference = $incomes - $outcomes;
        // $outcomes = Transaction::join('categories', 'categories.id', '=', 'transactions.category_id')
        // ->where('categories.is_expense', true);

        return [
            Stat::make('Income','Rp. ' .$incomes)
            ->color('success'),
            Stat::make('Outcome','Rp. '. $outcomes)
            ->color('danger'),
            Stat::make('Selisih', 'Rp. ' . $diference),
        ];
    }
}
