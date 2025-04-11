<?php

declare(strict_types=1);

namespace TLB\Dummy\Misc;

use Ramsey\Uuid\Uuid;
use TLB\Dummy\DataGenerator;
use TLB\Dummy\StringBuilder;

final class Identifier extends StringBuilder
{
    public static function uuid(): Identifier
    {
        return new self(DataGenerator::get()->uuid());
    }

    public static function uuid4(): Identifier
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return new self(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public static function uuid7(): Identifier
    {
        $uuid = Uuid::uuid7();

        return new self($uuid->toString());
    }
}
