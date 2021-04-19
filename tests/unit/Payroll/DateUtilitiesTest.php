<?php

declare(strict_types=1);

namespace Unit\Test\Payroll;

use App\Payroll\DateUtilities;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PHPUnit\Framework\TestCase;

class DateUtilitiesTest extends TestCase
{
    private DateUtilities $dateUtilities;

    public function setUp(): void
    {
        $this->dateUtilities = new DateUtilities();
    }

    /** @test */
    public function itReturnRemainMonths()
    {
        $this->assertInstanceOf(CarbonPeriod::class, $this->dateUtilities->getRemainingMonths(Carbon::create()));
        $this->assertSame(12, $this->dateUtilities->getRemainingMonths(Carbon::create())->count());
        $this->assertSame(9, $this->dateUtilities->getRemainingMonths(Carbon::create(0, 4, 19))->count());
    }

    /**
     * @test
     * @dataProvider lastWeekDayOfMonth()
     */
    public function itReturnTheLastWeekDayOfTheMonth(int $month, string $expectedDay)
    {
        $this->assertSame($expectedDay, $this->dateUtilities->getSalaryPayday(Carbon::create(2021, $month)));
    }

    /**
     * @test
     * @dataProvider fifteenthDayOfMonthOnWeekdays()
     */
    public function itReturnFifteenthDayOfTheMonthWhenTheDayIsNotWeekend(int $month, string $expectedDay)
    {
        $this->assertSame($expectedDay, $this->dateUtilities->getBonusPayday(Carbon::create(2021, $month)));
    }

    /**
     * @test
     * @dataProvider fifteenthDayOfMonthOnWeekends()
     */
    public function itReturnNextWednesdayOfTheMonthWhenTheFifteenthDayIsWeekend(int $month, string $expectedDay)
    {
        $this->assertSame($expectedDay, $this->dateUtilities->getBonusPayday(Carbon::create(2021, $month)));
    }

    public function lastWeekDayOfMonth()
    {
        yield [
            'month' => 4,
            'expectedDay' => 'Friday 30th',
        ];

        yield [
            'month' => 7,
            'expectedDay' => 'Friday 30th',
        ];

        yield [
            'month' => 8,
            'expectedDay' => 'Tuesday 31st',
        ];
    }

    public function fifteenthDayOfMonthOnWeekdays()
    {
        yield [
            'month' => 4,
            'expectedDay' => 'Thursday 15th',
        ];

        yield [
            'month' => 6,
            'expectedDay' => 'Tuesday 15th',
        ];
    }

    public function fifteenthDayOfMonthOnWeekends()
    {
        yield [
            'month' => 5,
            'expectedDay' => 'Wednesday 19th',
        ];

        yield [
            'month' => 8,
            'expectedDay' => 'Wednesday 18th',
        ];
    }
}
