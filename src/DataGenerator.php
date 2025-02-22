<?php

declare(strict_types=1);

namespace TLB\Dummy;

use Faker\Factory;
use Faker\Generator;
use TLB\Dummy\Geography\Locale;

final class DataGenerator
{
    private Generator $generator;
    private static self $instance;

    private function __construct(Locale $locale)
    {
        $this->generator = Factory::create($locale->value);
    }

    public static function get(Locale $locale = Locale::US_ENGLISH): Generator
    {
        if (!isset(self::$instance) || self::$instance->generator->locale() !== $locale->value) {
            self::$instance = new self($locale);
        }

        return self::$instance->generator;
    }
}
