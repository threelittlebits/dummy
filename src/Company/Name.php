<?php

declare(strict_types=1);

namespace TLB\Dummy\Company;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Name extends StringBuilder
{
    /**
     * Generates a random name.
     *
     * @return Name
     */
    public static function random(): Name
    {
        return new self(DataGenerator::get()->company());
    }
}
