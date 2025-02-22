<?php

declare(strict_types=1);

namespace TLB\Dummy\Contact;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\Company\Name as CompanyName;
use TLB\Dummy\Person\Name as PersonName;
use TLB\Dummy\StringBuilder;

final class Name extends StringBuilder
{
    /**
     * Generates a random name for a person or a company.
     *
     * @param string|null $personGender
     * @return Name
     */
    public static function companyOrPerson(?string $personGender = null): Name
    {
        $names = [
            self::personNameFromGender($personGender),
            CompanyName::random()->get(),
        ];

        return new self(DataGenerator::get()->randomElement($names));
    }

    private static function personNameFromGender(?string $personGender): string
    {
        return match ($personGender) {
            PersonName::MALE => PersonName::male()->get(),
            PersonName::FEMALE => PersonName::female()->get(),
            default => PersonName::random()->get()
        };
    }
}
