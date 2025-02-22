<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Payment;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Payment\Iban;

final class IbanTest extends TestCase
{
    private IbanValidator $ibanValidator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ibanValidator = new IbanValidator();
    }

    #[Test]
    public function random_shouldCreateAValidIban(): void
    {
        $iban = Iban::random();

        $ibanNumber = $iban->get();

        $this->assertTrue($this->ibanValidator->isValid($ibanNumber));
    }

    #[Test]
    public function spanish_shouldCreateAValidSpanishIban(): void
    {
        $iban = Iban::spanish();

        $ibanNumber = $iban->get();

        $this->assertTrue($this->ibanValidator->isValid($ibanNumber));
        $this->assertTrue(str_starts_with($ibanNumber, 'ES'));
    }

    #[Test]
    public function italian_shouldCreateAValidItalianIban(): void
    {
        $iban = Iban::italian();

        $ibanNumber = $iban->get();

        $this->assertTrue($this->ibanValidator->isValid($ibanNumber));
        $this->assertTrue(str_starts_with($ibanNumber, 'IT'));
    }

    #[Test]
    public function portuguese_shouldCreateAValidPortugueseIban(): void
    {
        $iban = Iban::portuguese();

        $ibanNumber = $iban->get();

        $this->assertTrue($this->ibanValidator->isValid($ibanNumber));
        $this->assertTrue(str_starts_with($ibanNumber, 'PT'));
    }

    #[Test]
    public function andorran_shouldCreateAValidAndorranIban(): void
    {
        $iban = Iban::andorran();

        $ibanNumber = $iban->get();

        $this->assertTrue($this->ibanValidator->isValid($ibanNumber));
        $this->assertTrue(str_starts_with($ibanNumber, 'AD'));
    }
}
