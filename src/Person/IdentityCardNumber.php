<?php

declare(strict_types=1);

namespace TLB\Dummy\Person;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class IdentityCardNumber extends StringBuilder
{
    public static function random(): IdentityCardNumber
    {
        $identityCards = [
            fn () => self::dni(),
            fn () => self::nie()
        ];

        $identityCard = DataGenerator::get()->randomElement($identityCards);

        return $identityCard();
    }

    public static function dni(): IdentityCardNumber
    {
        $dniLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $dniNumber = DataGenerator::get()->regexify('/^\d{8}$/');

        $letterPosition = (int) $dniNumber % 23;
        $letter = substr($dniLetters, $letterPosition, 1);

        return new self(sprintf('%s%s', $dniNumber, $letter));
    }

    public static function nie(): IdentityCardNumber
    {
        $nieLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $nieNumber = DataGenerator::get()->regexify('/^[XYZ]\d{7}$/');
        $nieNumber2 = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], $nieNumber);

        $letterPosition = (int) $nieNumber2 % 23;
        $letter = substr($nieLetters, $letterPosition, 1);

        return new self(sprintf('%s%s', $nieNumber, $letter));
    }
}
