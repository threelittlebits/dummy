<?php

declare(strict_types=1);

namespace TLB\Dummy\Primitives;

use TLB\Dummy\DataGenerator;

final class Boolean
{
    /**
     * Generate a random boolean.
     *
     * @return bool
     */
    public static function random(): bool
    {
        return DataGenerator::get()->boolean();
    }
}
