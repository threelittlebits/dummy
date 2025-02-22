<?php

declare(strict_types=1);

namespace TLB\Dummy\Payment;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\Geography\CountryCode;
use TLB\Dummy\StringBuilder;

final class Iban extends StringBuilder
{
    private const FORMATS = [
        'AD' => 'AD\d{2}\d{4}\d{4}[0-9A-Z]{12}',
        'IT' => 'IT\d{2}[A-Z]{1}\d{5}\d{5}[0-9A-Z]{12}',
        'PT' => 'PT\d{2}\d{4}\d{4}\d{11}\d{2}',
        'ES' => 'ES\d{2}\d{4}\d{4}\d{1}\d{1}\d{10}',
    ];

    protected function __construct(private readonly string $countryCode)
    {
        parent::__construct('');
    }

    public static function ofCountry(CountryCode $countryCode): self
    {
        return new self($countryCode->value);
    }

    public static function spanish(): self
    {
        return new self(CountryCode::spain());
    }

    public static function italian(): self
    {
        return new self(CountryCode::italy());
    }

    public static function portuguese(): self
    {
        return new self(CountryCode::portugal());
    }

    public static function andorran(): self
    {
        return new self(CountryCode::andorra());
    }

    public static function random(): self
    {
        $countryCode = DataGenerator::get()->randomElement(CountryCode::cases());

        return new self($countryCode->value);
    }

    public function get(): string
    {
        $this->str = $this->generate();

        return parent::get();
    }

    public function getOrNull(): ?string
    {
        $returnNull = DataGenerator::get()->boolean();

        if ($returnNull) {
            return null;
        }

        return $this->get();
    }

    private function generate(): string
    {
        $iban = DataGenerator::get()->regexify(self::FORMATS[$this->countryCode]);
        $iban = substr_replace($iban, '00', 2, 2);
        $reorderedIban = substr($iban, 4) . substr($iban, 0, 4);
        $converted = $this->toBigInt($reorderedIban);
        $remainder = $this->bigModulo97($converted);
        $checkDigits = 98 - $remainder;
        $checkDigits = str_pad((string) $checkDigits, 2, '0', STR_PAD_LEFT);

        return substr_replace($iban, $checkDigits, 2, 2);
    }

    private function toBigInt(string $string): string
    {
        $chars = str_split($string);
        $bigInt = '';

        foreach ($chars as $char) {
            // Convert uppercase characters to ordinals, starting with 10 for "A"
            if (ctype_upper($char)) {
                $bigInt .= (\ord($char) - 55);

                continue;
            }

            // Simply append digits
            $bigInt .= $char;
        }

        return $bigInt;
    }

    private function bigModulo97(string $bigInt): int
    {
        $parts = str_split($bigInt, 7);
        $rest = 0;

        foreach ($parts as $part) {
            $rest = ($rest.$part) % 97;
        }

        return $rest;
    }
}
