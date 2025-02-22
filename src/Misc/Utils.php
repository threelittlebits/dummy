<?php declare(strict_types=1);

namespace TLB\Dummy\Misc;

final class Utils
{
    public static function randomElement(iterable $collection): mixed
    {
        $array = iterator_to_array($collection);

        return $array[array_rand($array)];
    }
}
