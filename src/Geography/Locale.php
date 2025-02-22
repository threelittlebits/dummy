<?php

declare(strict_types=1);

namespace TLB\Dummy\Geography;

enum Locale: string
{
    case SPANISH = 'es_ES';
    case CATALAN = 'ca_ES';
    case US_ENGLISH = 'en_US';
    case UK_ENGLISH = 'en_GB';
    case ITALIAN = 'it_IT';
    case PORTUGUESE = 'pt_PT';
    case FRENCH = 'fr_FR';

    public function isSpanish(): bool
    {
        return $this === self::SPANISH;
    }

    public function random(): string
    {
        return match (rand(0, 6)) {
            0 => self::SPANISH->value,
            1 => self::CATALAN->value,
            2 => self::US_ENGLISH->value,
            3 => self::UK_ENGLISH->value,
            4 => self::ITALIAN->value,
            5 => self::PORTUGUESE->value,
            6 => self::FRENCH->value,
        };
    }
}
