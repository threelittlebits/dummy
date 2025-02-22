<?php

declare(strict_types=1);

namespace TLB\Dummy\Primitives;

use TLB\Dummy\Builder;
use TLB\Dummy\DataGenerator;
use TLB\Dummy\Primitives\Exceptions\DecimalException;

final class Decimal extends Builder
{
    private const PRECISION = 2;

    protected function __construct(private readonly float $value)
    {
    }

    public static function between(float $min, float $max, int $precision = self::PRECISION): self
    {
        if ($max <= $min) {
            throw new DecimalException(sprintf('The maximum value must be greater than %d', $min));
        }

        $value = round($min + DataGenerator::get()->numberBetween() / mt_getrandmax() * ($max - $min), $precision);

        return new self($value);
    }

    public static function nonNegative(?float $max = null, int $precision = self::PRECISION): self
    {
        if (is_null($max)) {
            $max = Integer::positive()->get();
        }

        return new self(self::generateZeroOrPositiveFloat(0, $max, $precision));
    }

    public static function positive(?float $max = null, int $precision = self::PRECISION): self
    {
        if (is_null($max)) {
            $max = Integer::random(2)->get();
        }

        return new self(self::generateZeroOrPositiveFloat(1, $max, $precision));
    }

    private static function generateZeroOrPositiveFloat(int $min, float $max, int $precision): float
    {
        if ($max <= $min) {
            throw new DecimalException(sprintf('The maximum value must be greater than %d', $min));
        }

        return round($min + DataGenerator::get()->numberBetween() / mt_getrandmax() * ($max - $min), $precision);
    }

    public static function nonPositive(?float $min = null, int $precision = self::PRECISION): self
    {
        $max = 0;
        if (is_null($min)) {
            $min = Integer::negative()->get();
        } else {
            if ($min > $max) {
                throw new DecimalException('The minimum value must be less than 0');
            }
        }

        $number = round($min + DataGenerator::get()->numberBetween() / mt_getrandmax() * ($max - $min), $precision);

        return new self($number);
    }

    public static function negative(?float $min = null, int $precision = self::PRECISION): self
    {
        if (is_null($min)) {
            $min = Integer::negative()->get();
        } else {
            if ($min >= 0) {
                throw new DecimalException('The minimum value must be less than 0');
            }
        }

        $max = -1;

        $number = round($min + DataGenerator::get()->numberBetween() / mt_getrandmax() * ($max - $min), $precision);

        return new self($number);
    }

    public static function zero(): self
    {
        return new self(0.0);
    }

    public function get(): float
    {
        return $this->value;
    }
}
