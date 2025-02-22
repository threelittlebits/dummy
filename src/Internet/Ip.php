<?php

declare(strict_types=1);

namespace TLB\Dummy\Internet;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Ip extends StringBuilder
{
    const LOOPBACK_ADDRESS = '127.0.0.1';
    const UNKNOWN_ADDRESS = '0.0.0.0';

    public static function loopback(): Ip
    {
        return new self(self::LOOPBACK_ADDRESS);
    }

    public static function local(): Ip
    {
        return new self(DataGenerator::get()->localIpv4());
    }

    public static function unknown(): Ip
    {
        return new self(self::UNKNOWN_ADDRESS);
    }

    public static function random(): Ip
    {
        return new self(DataGenerator::get()->ipv4());
    }
}
