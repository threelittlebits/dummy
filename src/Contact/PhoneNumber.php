<?php

declare(strict_types=1);

namespace TLB\Dummy\Contact;

use TLB\Dummy\DataGenerator;
use TLB\Dummy\Geography\CountryCode;
use TLB\Dummy\Primitives\Boolean;
use TLB\Dummy\StringBuilder;

final class PhoneNumber extends StringBuilder
{
    private const COUNTRY_CODE_MAP = [
        'ES' => '34',
        'IT' => '39',
        'PT' => '351',
        'AD' => '376',
    ];

    private const SPANISH_AREA_CODES = [
        '981',
        '945',
        '967',
        '965',
        '950',
        '984',
        '920',
        '924',
        '971',
        '93',
        '947',
        '927',
        '956',
        '942',
        '964',
        '926',
        '957',
        '969',
        '972',
        '958',
        '949',
        '943',
        '959',
        '974',
        '953',
        '941',
        '928',
        '987',
        '973',
        '982',
        '91',
        '952',
        '968',
        '948',
        '988',
        '979',
        '986',
        '923',
        '921',
        '955',
        '975',
        '977',
        '922',
        '978',
        '925',
        '96',
        '983',
        '94',
        '980',
        '976'
    ];

    private CountryCode $countryCode = CountryCode::SPAIN;
    private bool $shouldHaveCountryCode = false;
    private bool $isMobile;

    protected function __construct(bool $isMobile = true)
    {
        parent::__construct('');

        $this->isMobile = $isMobile;
    }

    public static function mobile(): self
    {
        return new self(true);
    }

    public static function landline(): self
    {
        return new self(false);
    }

    public static function random(): self
    {
        return new self(Boolean::random());
    }

    public function spanish(): self
    {
        $this->countryCode = CountryCode::SPAIN;

        return $this;
    }

    public function withCountryCode(): self
    {
        $this->shouldHaveCountryCode = true;

        return $this;
    }

    private function generateNumber(): string
    {
        $dataGenerator = DataGenerator::get();

        if ($this->countryCode->isSpain()) {
            return $this->generateSpanish();
        }

        return $dataGenerator->phoneNumber();
    }

    private function generateSpanish(): string
    {
        assert($this->countryCode->isSpain());

        $dataGenerator = DataGenerator::get();

        if ($this->isMobile) {
            return $dataGenerator->regexify('6\d{2}\d{6}');
        }

        $areaCode = $dataGenerator->randomElement(self::SPANISH_AREA_CODES);

        $numberRegex = strlen($areaCode) === 3 ? '/^\d{6}$/' : '/^[1-8]{7}$/';

        $phoneNumber = $dataGenerator->regexify($numberRegex);

        return sprintf('%s%s', $areaCode, $phoneNumber);
    }

    public function get(): string
    {
        $number = $this->generateNumber();

        if ($this->shouldHaveCountryCode) {
            $number = sprintf('+%s%s', self::COUNTRY_CODE_MAP[$this->countryCode->value], $number);
        }

        return $number;
    }
}
