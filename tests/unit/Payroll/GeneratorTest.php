<?php

declare(strict_types=1);

namespace Unit\Test\Payroll;

use App\Payroll\DateUtilities;
use App\Payroll\Generator;
use App\Payroll\Payroll;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    /** @test */
    public function itPreparesPayrollForRemainingMonths()
    {
        $dateUtility = new DateUtilities();

        $payrollGenerator = new Generator($dateUtility);

        /** @var Payroll[] $payrolls */
        $payrolls = $payrollGenerator->generate(Carbon::create(2021, 11));

        $this->assertCount(2, $payrolls);
        $this->assertSame('November', $payrolls[0]->getMonth());
        $this->assertSame('Tuesday 30th', $payrolls[0]->getSalaryPayday());
        $this->assertSame('Monday 15th', $payrolls[0]->getBonusPayday());
    }
}
