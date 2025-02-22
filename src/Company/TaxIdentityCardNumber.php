<?php

declare(strict_types=1);

namespace TLB\Dummy\Company;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class TaxIdentityCardNumber extends StringBuilder
{
    public static function cif(): TaxIdentityCardNumber
    {
        $cifIdNumber = DataGenerator::get()->regexify('/^[ABCDEFGHJPQRSUVW][0-9]{1}[1-9]{1}\d{5}$/');
        $firstDigitsNumbers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'U', 'V'];
        $firstDigit = substr($cifIdNumber, 0, 1);
        $documentNumber = substr($cifIdNumber, 1);
        $cifNumbers = str_split($documentNumber);

        $position = 1;
        $even = [];
        $odd = [];
        foreach ($cifNumbers as $cifNumber) {
            if (0 === $position % 2) {
                $even[] = (int) $cifNumber;
            } else {
                $odd[] = (int) $cifNumber * 2;
            }

            ++$position;
        }

        $evenSum = self::reduce(
            fn (int $acc, int $num) => $acc + $num,
            $even,
            0
        );

        $oddMultiplied = array_map(
            function (int $num) {
                $strNum = (string) $num;
                if (1 === strlen($strNum)) {
                    return $num;
                }

                list($first, $second) = str_split($strNum);

                return (int) $first + (int) $second;
            },
            $odd
        );

        $oddSum = self::reduce(
            fn (int $acc, int $num) => $acc + $num,
            $oddMultiplied,
            0
        );

        $partialSum = $evenSum + $oddSum;
        $control = $partialSum % 10;

        if (0 !== $control) {
            $control = 10 - $control;
        }

        if (!in_array($firstDigit, $firstDigitsNumbers)) {
            $control = substr('JABCDEFGHI', $control, 1);
        }

        return new self(sprintf('%s%s', $cifIdNumber, $control));
    }

    private static function reduce(callable $fn, iterable $coll, int $initial): int
    {
        $acc = $initial;

        foreach ($coll as $key => $value) {
            $acc = $fn($acc, $value, $key);
        }

        return $acc;
    }
}
