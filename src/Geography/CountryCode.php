<?php

declare(strict_types=1);

namespace TLB\Dummy\Geography;

enum CountryCode: string
{
    case SPAIN = 'ES';
    case ITALY = 'IT';
    case PORTUGAL = 'PT';
    case ANDORRA = 'AD';

    public static function spain(): string
    {
        return self::SPAIN->value;
    }

    public static function italy(): string
    {
        return self::ITALY->value;
    }

    public static function portugal(): string
    {
        return self::PORTUGAL->value;
    }

    public static function andorra(): string
    {
        return self::ANDORRA->value;
    }

    public function isSpain(): bool
    {
        return $this === self::SPAIN;
    }

    public function isItaly(): bool
    {
        return $this === self::ITALY;
    }

    public function isPortugal(): bool
    {
        return $this === self::PORTUGAL;
    }

    public function isAndorra(): bool
    {
        return $this === self::ANDORRA;
    }

    public function random(): string
    {
        return match (rand(0, 3)) {
            0 => self::SPAIN->value,
            1 => self::ITALY->value,
            2 => self::PORTUGAL->value,
            3 => self::ANDORRA->value,
        };
    }
}
