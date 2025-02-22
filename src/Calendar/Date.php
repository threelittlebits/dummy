<?php

declare(strict_types=1);

namespace TLB\Dummy\Calendar;

use TLB\Dummy\Builder;
use TLB\Dummy\DataGenerator;

final class Date extends Builder
{
    private const MINUS = '-';
    private const PLUS = '+';
    private const CURRENT = 'now';

    private ?\DateTime $dateTime = null;

    private ?string $dateTimeString;
    private bool $mutable;
    private ?\DateTimeZone $timezone = null;
    private array $format;
    private ?int $hour = null;
    private ?int $minutes = null;
    private ?int $seconds = null;
    private ?string $currentOperator = null;

    private function __construct(?string $dateTimeString = null, bool $mutable = false)
    {
        $this->dateTimeString = $dateTimeString;
        $this->mutable = $mutable;
        $this->format = [];
    }

    public static function current(): self
    {
        return new self(self::CURRENT);
    }

    public static function immutable(string $dateTimeString = self::CURRENT): self
    {
        return new self($dateTimeString, false);
    }

    public static function mutable(string $dateTimeString = self::CURRENT): self
    {
        return new self($dateTimeString, true);
    }

    public function spanish(): self
    {
        $this->timezone = new \DateTimeZone('Europe/Madrid');

        return $this;
    }

    public function portuguese(): self
    {
        $this->timezone = new \DateTimeZone('Europe/Lisbon');

        return $this;
    }

    public function withTimeZone(\DateTimeZone $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public static function between(string $start, string $end = self::CURRENT, bool $mutable = false): self
    {
        if (new \DateTime($start) > new \DateTime($end)) {
            throw new CalendarException('Start date must be less than end date');
        }

        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween($start, $end));

        return $date;
    }

    public static function withinNextYear(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween(self::CURRENT, '+1 year'));

        return $date;
    }

    public static function withinLastYear(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween('-1 year', self::CURRENT));

        return $date;
    }

    public static function withinNextMonth(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = DataGenerator::get()->dateTimeBetween(self::CURRENT, '+1 month');

        return $date;
    }

    public static function withinLastMonth(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween('-1 month', self::CURRENT));

        return $date;
    }

    public static function withinNextWeek(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween(self::CURRENT, '+1 week'));

        return $date;
    }

    public static function withinLastWeek(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween('-1 week', self::CURRENT));

        return $date;
    }

    public static function withinLastDays(int $days, bool $mutable = false): self
    {
        if ($days <= 0) {
            throw new CalendarException('Days number must be greater than 0');
        }

        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(
            DataGenerator::get()->dateTimeBetween(sprintf('-%d days', $days), self::CURRENT)
        );

        return $date;
    }

    public static function withinNextDays(int $days, bool $mutable = false): self
    {
        if ($days <= 0) {
            throw new CalendarException('Days number must be greater than 0');
        }

        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(
            DataGenerator::get()->dateTimeBetween(self::CURRENT, sprintf('+%d days', $days))
        );

        return $date;
    }

    public static function tomorrow(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween('tomorrow', 'tomorrow 23:59:59'));

        return $date;
    }

    public static function yesterday(bool $mutable = false): self
    {
        $date = new self(mutable: $mutable);
        $date->dateTime = self::dateTimeFrom(DataGenerator::get()->dateTimeBetween('yesterday', 'yesterday 23:59:59'));

        return $date;
    }

    private static function dateTimeFrom(\DateTime $dateTime, ?\DateTimeZone $timezone = null): \DateTime
    {
        return \DateTime::createFromFormat(\DateTime::ATOM, $dateTime->format(\DateTime::ATOM), $timezone);
    }

    public function minus(int $number, TimeUnit $unit): self
    {
        if ($number < 0) {
            throw new CalendarException(
                sprintf('%s number must be greater than 0', $unit->value)
            );
        }

        $this->format[] = sprintf('%s%d %s', self::MINUS, $number, $unit->value);
        $this->currentOperator = self::MINUS;

        return $this;
    }

    public function plus(int $number, TimeUnit $unit): self
    {
        if ($number < 0) {
            throw new CalendarException(
                sprintf('%s number must be greater than 0', $unit->value)
            );
        }

        $this->format[] = sprintf('%s%d %s', self::PLUS, $number, $unit->value);
        $this->currentOperator = self::PLUS;

        return $this;
    }

    public function plusDays(int $number): self
    {
        return $this->plus($number, TimeUnit::DAYS);
    }

    public function minusDays(int $number): self
    {
        return $this->minus($number, TimeUnit::DAYS);
    }

    public function and(int $number, TimeUnit $unit): self
    {
        if (is_null($this->currentOperator)) {
            throw new CalendarException('You must use minus or plus before and');
        }

        $this->format[] = sprintf('%s%d %s', $this->currentOperator, $number, $unit->value);

        return $this;
    }

    public function atMidnight(): self
    {
        return $this->at(0, 0);
    }

    public function at(int $hour, int $minute, int $second = 0): self
    {
        $this->hour = $hour;
        $this->minutes = $minute;
        $this->seconds = $second;

        return $this;
    }

    public function get(): \DateTimeInterface
    {
        if (!is_null($this->dateTime)) {
            $dateTime = $this->dateTime;
            if (!is_null($this->timezone)) {
                $dateTime->setTimezone($this->timezone);
            }
        } else {
            $dateTime = self::dateTimeFrom(new \DateTime($this->dateTimeString, $this->timezone), $this->timezone);
        }

        if (!$this->mutable) {
            $dateTime = \DateTimeImmutable::createFromMutable($dateTime);
        }

        if (!is_null($this->hour) && !is_null($this->minutes) && !is_null($this->seconds)) {
            $dateTime = $dateTime->setTime($this->hour, $this->minutes, $this->seconds);
        }

        if (!empty($this->format)) {
            $dateTime = $dateTime->modify(implode(' ', $this->format));
        }

        return $dateTime;
    }

    public function getMutable(): \DateTime
    {
        $date = $this->get();

        if ($date instanceof \DateTime) {
            return $date;
        }

        return \DateTime::createFromInterface($date);
    }

    public function getImmutable(): \DateTimeImmutable
    {
        $date = $this->get();

        if ($date instanceof \DateTimeImmutable) {
            return $date;
        }

        return \DateTimeImmutable::createFromInterface($date);
    }

    public function getOrEmpty(): \DateTimeInterface
    {
        $emptyDateString = '0000-00-00 00:00:00';

        if ($this->mutable) {
            return new \DateTime($emptyDateString);
        }

        return new \DateTimeImmutable($emptyDateString);
    }
}
