<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $incomes = Transaction::incomes()->get()->sum('amount');
        $outcomes = Transaction::expenses()->get()->sum('amount');
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
