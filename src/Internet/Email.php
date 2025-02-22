<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Email extends StringBuilder
{
    /**
     * Generate a random email address.
     *
     * @return Email
     */
    public static function random(): Email
    {
        $emails = [
            fn () => new self(DataGenerator::get()->email()),
            fn () => self::example(),
            fn () => self::company(),
            fn () => self::free(),
        ];

        $email = DataGenerator::get()->randomElement($emails);

        return $email();
    }

    /**
     * Generate a safe email address.
     *
     * @return Email
     */
    public static function example(): Email
    {
        return new self(DataGenerator::get()->safeEmail());
    }

    public static function company(): Email
    {
        return new self(DataGenerator::get()->companyEmail());
    }

    public static function free(): Email
    {
        return new self(DataGenerator::get()->freeEmail());
    }
}
