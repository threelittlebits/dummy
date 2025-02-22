<?php

declare(strict_types=1);

namespace TLB\Dummy\Payment;

use TLB\Dummy\StringBuilder;

final class Currency extends StringBuilder
{
    private const CURRENCIES = [
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'decimals' => 2,
        ],
    ];

    public static function euro(): Currency
    {
        return new self('EUR');
    }

    public function details(): array
    {
        return self::CURRENCIES[$this->str];
    }
}
