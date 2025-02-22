<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Url extends StringBuilder
{
    public static function random(): Url
    {
        return new self(DataGenerator::get()->url());
    }

    public static function example(): string
    {
        return 'https://example.' . DataGenerator::get()->randomElement(['com', 'org', 'net']);
    }
}
