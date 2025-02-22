<?php

declare(strict_types=1);

namespace TLB\Dummy\Mixed;

use TLB\Dummy\Company\TaxIdentityCardNumber;
use TLB\Dummy\DataGenerator;
use TLB\Dummy\Person\IdentityCardNumber as PersonIdentityCardNumber;

final class IdentityCardNumber
{
    public static function random(bool $optional = false): ?string
    {
        $dataGenerator = DataGenerator::get();

        $identityCardNumbers = [
            PersonIdentityCardNumber::dni(),
            PersonIdentityCardNumber::nie(),
            TaxIdentityCardNumber::cif()
        ];

        $identityCardNumber = $dataGenerator->randomElement($identityCardNumbers);

        if ($optional) {
            return $identityCardNumber->getOrNull();
        }

        return $identityCardNumber->get();
    }
}
