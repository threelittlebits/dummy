<?php

declare(strict_types=1);

namespace TLB\Dummy\Primitives;

use TLB\Dummy\Builder;
use TLB\Dummy\DataGenerator;

final class Integer extends Builder
{
    public const MIN = -2147483648;
    public const MAX = 2147483647;

    protected function __construct(private readonly int $value)
    {
    }

    public static function nonNegative(int $max = self::MAX): self
    {
        return new self(DataGenerator::get()->numberBetween(0, $max));
    }

    public static function nonPositive(int $min = self::MAX): self
    {
        return new self(DataGenerator::get()->numberBetween($min, 0));
    }

    public static function positive(int $max = self::MAX): self
    {
        return new self(DataGenerator::get()->numberBetween(1, $max));
    }

    public static function negative(int $min = self::MIN): self
    {
        return new self(DataGenerator::get()->numberBetween($min, -1));
    }

    public static function random(int $min = self::MIN, int $max = self::MAX): self
    {
        return new self(DataGenerator::get()->numberBetween($min, $max));
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function digits(int $numberOfDigits): self
    {
        return new self(DataGenerator::get()->randomNumber($numberOfDigits, true));
    }

    public static function digit(bool $includeZero = true): self
    {
        if ($includeZero) {
            return self::nonNegative(9);
        }

        return self::positive(9);
    }

    public function get(): int
    {
        return $this->value;
    }
}
