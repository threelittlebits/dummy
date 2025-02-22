<?php

declare(strict_types=1);

namespace Tests\TLB\Dummy\Contact;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TLB\Dummy\Contact\Address;

final class AddressTest extends TestCase
{
    #[Test]
    public function province_shouldReturnAProvince(): void
    {
        $province = Address::spanish()->province()->get();

        $this->assertNotEmpty($province);
    }

    #[Test]
    public function floor_shouldReturnAFloor(): void
    {
        $floor = Address::spanish()->floor()->get();

        $this->assertNotEmpty($floor);
    }

    #[Test]
    public function door_shouldReturnADoor(): void
    {
        $door = Address::spanish()->door()->get();

        $this->assertNotEmpty($door);
    }
}
