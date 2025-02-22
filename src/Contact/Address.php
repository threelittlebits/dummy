<?php

declare(strict_types=1);

namespace TLB\Dummy\Contact;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\Geography\Locale;
use TLB\Dummy\Misc\Utils;
use TLB\Dummy\Primitives\Str;
use TLB\Dummy\StringBuilder;

/**
 * @method StringBuilder address()
 * @method StringBuilder province()
 * @method StringBuilder city()
 * @method StringBuilder streetName()
 * @method StringBuilder streetAddress()
 * @method StringBuilder number()
 * @method StringBuilder postcode()
 * @method StringBuilder country()
 * @method StringBuilder elements()
 * @method StringBuilder floor()
 * @method StringBuilder door()
 */
final class Address extends StringBuilder
{
    private const ADDRESS = 'address';
    private const PROVINCE = 'province';
    private const CITY = 'city';
    private const STREET_NAME = 'streetName';
    private const STREET_ADDRESS = 'streetAddress';
    private const NUMBER = 'number';
    private const POSTCODE = 'postcode';
    private const COUNTRY = 'country';
    private const ELEMENTS = 'elements';
    private const FLOOR = 'floor';
    private const DOOR = 'door';

    private const ADDRESS_PARTS = [
        self::ADDRESS,
        self::PROVINCE,
        self::CITY,
        self::STREET_NAME,
        self::STREET_ADDRESS,
        self::NUMBER,
        self::POSTCODE,
        self::COUNTRY,
        self::ELEMENTS,
        self::FLOOR,
        self::DOOR
    ];

    private const ADDRESS_PARTS_METHOD = [
        self::ADDRESS => 'address',
        self::PROVINCE => 'state',
        self::CITY => 'city',
        self::STREET_NAME => 'streetName',
        self::STREET_ADDRESS => 'streetAddress',
        self::COUNTRY => 'country',
        self::ELEMENTS => 'secondaryAddress',
    ];

    protected function __construct(string $address, protected Locale $locale)
    {
        parent::__construct($address);
    }

    public static function create(): self
    {
        $dataGenerator = DataGenerator::get();

        $locale = $dataGenerator->randomElement([
            Locale::SPANISH,
            Locale::ITALIAN,
            Locale::PORTUGUESE,
        ]);

        return new self(DataGenerator::get($locale)->address(), $locale);
    }

    public static function spanish(): self
    {
        return new self(DataGenerator::get(Locale::SPANISH)->address(), Locale::SPANISH);
    }

    public static function italian(): self
    {
        return new self(DataGenerator::get(Locale::ITALIAN)->address(), Locale::ITALIAN);
    }

    public static function portuguese(): self
    {
        return new self(DataGenerator::get(Locale::PORTUGUESE)->address(), Locale::PORTUGUESE);
    }

    public function __call(string $method, array $arguments): StringBuilder
    {
        if (!in_array($method, self::ADDRESS_PARTS)) {
            throw new \BadMethodCallException(sprintf('Method %s does not exist', $method));
        }

        if ($method === self::NUMBER) {
            $str = $this->generateNumber();
        } else if ($method === self::POSTCODE) {
            $str = $this->generatePostcode();
        } else if ($method === self::FLOOR) {
            $str = $this->generateFloor();
        } else if ($method === self::DOOR) {
            $str = $this->generateDoor();
        } else {
            $addressPart = self::ADDRESS_PARTS_METHOD[$method];
            $str = DataGenerator::get($this->locale)->{$addressPart}();
        }

        return new class($str) extends StringBuilder {};
    }

    private function generateNumber(): string
    {
        return (string) DataGenerator::get()->numberBetween(1, 1000);
    }

    private function generatePostcode(): string
    {
        $dataGenerator = DataGenerator::get($this->locale);

        if ($this->locale->isSpanish()) {
            $provinces = range(1, 52);
            $provincesStr = array_map(
                fn(int $provinceId) => str_pad((string)$provinceId, 2, '0', STR_PAD_LEFT),
                $provinces
            );

            $nums = range(1, 999);

            $numStr = array_map(
                fn(int $num) => str_pad((string)$num, 3, '0', STR_PAD_LEFT),
                $nums
            );

            return sprintf(
                '%s%s',
                $dataGenerator->randomElement($provincesStr),
                $dataGenerator->randomElement($numStr)
            );
        }

        return $dataGenerator->postcode();
    }

    private function generateFloor(): string
    {
        $dataGenerator = DataGenerator::get($this->locale);

        if ($this->locale->isSpanish()) {
            $floorFormats = [
                'Bajos',
                'Ático',
                'Entresuelo',
                'Bajo',
                'Primero',
                'Segundo',
                'Tercero',
                'Cuarto',
                'Quinto',
                'Sexto',
                '#º'
            ];

            return str_replace(
                '#',
                Str::number(1)->get(),
                Utils::randomElement($floorFormats)
            );
        }

        return $dataGenerator->secondaryAddress();
    }

    private function generateDoor(): string
    {
        $dataGenerator = DataGenerator::get($this->locale);

        if ($this->locale->isSpanish()) {
            return Utils::randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']);
        }

        return $dataGenerator->secondaryAddress();
    }
}
