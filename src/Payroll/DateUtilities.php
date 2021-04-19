<?php

declare(strict_types=1);

namespace App\Payroll;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateUtilities
{
    public function getRemainingMonths(Carbon $start): CarbonPeriod
    {
        return Carbon::parse($start)->monthsUntil($start->endOfYear());
    }

    public function getSalaryPayday(Carbon $carbon): string
    {
        $endOfMonth = $carbon->endOfMonth();
        if ($endOfMonth->isWeekend()) {
            $endOfMonth->modify('previous friday');
        }

        return $endOfMonth->format('l jS');
    }

    public function getBonusPayday(Carbon $carbon): string
    {
        $fifteenthOfMonth = $carbon->firstOfMonth()->addDays(14);
        if ($fifteenthOfMonth->isWeekend()) {
            $fifteenthOfMonth->modify('next wednesday');
        }

        return $fifteenthOfMonth->format('l jS');
    }
}
