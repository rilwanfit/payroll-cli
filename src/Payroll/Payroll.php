<?php

declare(strict_types=1);

namespace App\Payroll;

class Payroll
{
    private string $month;

    private string $salaryPayday;

    private string $bonusPayday;

    public function __construct(string $month, string $salaryPayday, string $bonusPayday)
    {
        $this->month = $month;
        $this->salaryPayday = $salaryPayday;
        $this->bonusPayday = $bonusPayday;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function getSalaryPayday(): string
    {
        return $this->salaryPayday;
    }

    public function getBonusPayday(): string
    {
        return $this->bonusPayday;
    }

    public function toArray(): array
    {
        return [
            $this->month,
            $this->salaryPayday,
            $this->bonusPayday,
        ];
    }
}
