<?php

declare(strict_types=1);

namespace App\Payroll;

use Carbon\Carbon;

final class Generator
{
    private DateUtilities $dateUtilities;

    public function __construct(DateUtilities $dateUtilities)
    {
        $this->dateUtilities = $dateUtilities;
    }

    public function generate(Carbon $carbon): array
    {
        $records = [];

        $remainingMonths = $this->dateUtilities->getRemainingMonths($carbon);

        /** @var Carbon $month */
        foreach ($remainingMonths as $month) {
            $records[] = new Payroll(
                $month->getTranslatedMonthName(),
                $this->dateUtilities->getSalaryPayday($month),
                $this->dateUtilities->getBonusPayday($month)
            );
        }

        return $records;
    }
}
