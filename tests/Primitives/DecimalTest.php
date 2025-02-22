<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Primitives;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Primitives\Decimal;
use TLB\Dummy\Primitives\Exceptions\DecimalException;

final class DecimalTest extends TestCase
{
    #[Test]
    public function positive_shouldReturnAPositiveFloat(): void
    {
        $number = Decimal::positive();

        $this->assertIsFloat($number->get());
        $this->assertTrue($number->get() > 0);
    }

    #[Test]
    public function nonNegative_shouldReturnAPositiveFloatOrZero(): void
    {
        $number = Decimal::nonNegative();

        $this->assertIsFloat($number->get());
        $this->assertTrue($number->get() >= 0);
    }

    #[Test]
    public function negative_shouldReturnANegativeFloat(): void
    {
        $number = Decimal::negative(-10);

        $this->assertIsFloat($number->get());
        $this->assertTrue($number->get() < 0);
    }

    #[Test]
    public function negative_withMinGreaterThanZero_throwDecimalException(): void
    {
        $this->expectException(DecimalException::class);

        Decimal::negative(1);
    }

    #[Test]
    public function nonPositive_shouldReturnANegativeFloatOrZero(): void
    {
        $number = Decimal::nonPositive();

        $this->assertIsFloat($number->get());
        $this->assertTrue($number->get() <= 0);
    }

    #[Test]
    public function nonPositive_withMinGreaterThanZero_throwDecimalException(): void
    {
        $this->expectException(DecimalException::class);

        Decimal::nonPositive(1);
    }
}
