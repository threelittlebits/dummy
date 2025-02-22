<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Calendar;

use Faker\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Calendar\CalendarException;
use TLB\Dummy\Calendar\Date;
use TLB\Dummy\Calendar\TimeUnit;

final class DateTest extends TestCase
{
    #[Test]
    public function mutable_createsADateTimeInstance(): void
    {
        $date = Date::mutable()->get();

        $this->assertInstanceOf(\DateTime::class, $date);
        $this->assertEquals(0, (int)$date->format('u'));
        $this->assertEquals(0, (int)$date->format('v'));
    }

    #[Test]
    public function immutable_createsADateTimeImmutableInstance(): void
    {
        $date = Date::immutable()->get();

        $this->assertInstanceOf(\DateTimeImmutable::class, $date);
    }

    #[Test]
    #[DataProvider('days')]
    public function plus_addingDays_shouldSumDays(string $original, int $numberOfDaysAdded, string $result): void
    {
        $date = Date::mutable($original)
            ->plus($numberOfDaysAdded, TimeUnit::DAYS)
            ->get();

        $this->assertEquals($result, $date->format('Y-m-d H:i:s'));
    }

    #[Test]
    #[DataProvider('days')]
    public function minus_subtractingDays_shouldSubtractDays(string $result, int $numberOfDaysSubtracted, string $original): void
    {
        $date = Date::mutable($original)
            ->minus($numberOfDaysSubtracted, TimeUnit::DAYS)
            ->get();

        $this->assertEquals($result, $date->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function plus_withNegativeNumberOfDays_throwsCalendarException(): void
    {
        $this->expectException(CalendarException::class);

        Date::mutable()
            ->plus(-1, TimeUnit::DAYS)
            ->get();
    }

    #[Test]
    public function minus_withNegativeNumberOfDays_throwsCalendarException(): void
    {
        $this->expectException(CalendarException::class);

        Date::mutable()
            ->minus(-1, TimeUnit::DAYS)
            ->get();
    }

    #[Test]
    public function between_withEndDateAnteriorToStartDate_throwsCalendarException(): void
    {
        $this->expectException(CalendarException::class);

        Date::between('now', '1974-01-01 00:00:00');
    }

    #[Test]
    public function between_withEndDatePosteriorToStartDate_createsACorrectDate(): void
    {
        $date = Date::between('1974-01-01 00:00:00')->get();

        $this->assertInstanceOf(\DateTimeInterface::class, $date);
        $this->assertTrue($date->getTimestamp() >= strtotime('1974-01-01 00:00:00'));
    }

    #[Test]
    public function yesterday_mutableOrImmutable_createsACorrectDateWithinYesterday(): void
    {
        $faker = Factory::create();

        $date = Date::yesterday($faker->boolean())->get();

        $yesterday = new \DateTimeImmutable('yesterday');

        $this->assertInstanceOf(\DateTimeInterface::class, $date);
        $this->assertGreaterThanOrEqual($yesterday, $date);
        $this->assertLessThan($yesterday->modify('+1 day'), $date);
    }

    #[Test]
    public function tomorrow_mutableOrImmutable_createsACorrectDateWithinTomorrow(): void
    {
        $faker = Factory::create();

        $date = Date::tomorrow($faker->boolean())->get();

        $tomorrow = new \DateTimeImmutable('tomorrow');

        $this->assertInstanceOf(\DateTimeInterface::class, $date);
        $this->assertGreaterThanOrEqual($tomorrow, $date);
        $this->assertLessThan($tomorrow->modify('+1 day'), $date);
    }


    public static function days(): array
    {
        return [
            ['2024-01-01 00:00:00', 0, '2024-01-01 00:00:00'],
            ['2024-01-01 00:00:00', 1, '2024-01-02 00:00:00'],
            ['2024-01-01 00:00:00', 2, '2024-01-03 00:00:00'],
            ['2024-01-01 00:00:00', 3, '2024-01-04 00:00:00'],
            ['2024-01-01 00:00:00', 4, '2024-01-05 00:00:00'],
            ['2024-01-01 00:00:00', 5, '2024-01-06 00:00:00'],
            ['2024-01-01 00:00:00', 6, '2024-01-07 00:00:00'],
            ['2024-01-01 00:00:00', 7, '2024-01-08 00:00:00'],
            ['2024-01-01 00:00:00', 8, '2024-01-09 00:00:00'],
            ['2024-01-01 00:00:00', 9, '2024-01-10 00:00:00'],
            ['2024-01-01 00:00:00', 10, '2024-01-11 00:00:00'],
            ['2024-01-01 00:00:00', 30, '2024-01-31 00:00:00'],
            ['2024-01-01 00:00:00', 31, '2024-02-01 00:00:00'],
            ['2024-02-28 00:00:00', 1, '2024-02-29 00:00:00'],
            ['2023-02-28 00:00:00', 1, '2023-03-01 00:00:00'],
        ];
    }
}
