<?php

declare(strict_types=1);

namespace TLB\Dummy\Person;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Name extends StringBuilder
{
    public const MALE = 'male';
    public const FEMALE = 'female';

    /**
     * Generates a random male name.
     *
     * @return Name
     */
    public static function male(): Name
    {
        return new self(DataGenerator::get()->name(self::MALE));
    }

    /**
     * Generates a random first name.
     *
     * @param string|null $gender
     * @return Name
     */
    public static function firstName(?string $gender = null): Name
    {
        return new self(DataGenerator::get()->firstName($gender));
    }

    /**
     * Generates a random last name.
     *
     * @return Name
     */
    public static function lastName(): Name
    {
        return new self(DataGenerator::get()->lastName());
    }

    /**
     * Generates a random female name.
     *
     * @return Name
     */
    public static function female(): Name
    {
        return new self(DataGenerator::get()->name(self::FEMALE));
    }

    /**
     * Generates a random name.
     *
     * @return Name
     */
    public static function random(): Name
    {
        return new self(DataGenerator::get()->name());
    }
}
