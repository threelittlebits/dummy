<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Contact;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Contact\PhoneNumber;

final class PhoneNumberTest extends TestCase
{
    #[Test]
    public function spanish_withCountryCode_shouldConformToCountryPhoneCodePattern(): void
    {
        $phoneNumber = PhoneNumber::mobile()->withCountryCode()->spanish()->get();

        $this->assertMatchesRegularExpression('/^\+346\d{2}\d{6}$/', $phoneNumber);
    }

    #[Test]
    public function spanish_withCountryCode_shouldConformToPhonePattern(): void
    {
        $phoneNumber = PhoneNumber::mobile()->spanish()->get();

        $this->assertMatchesRegularExpression('/^6\d{2}\d{6}$/', $phoneNumber);
    }
}
