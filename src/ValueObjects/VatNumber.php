<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Data\VatNumberAuthenticationData;
use IBroStudio\DataRepository\Exceptions\UnauthenticatableGBVatNumberException;
use IBroStudio\DataRepository\Exceptions\UnauthenticatedVatNumberException;
use IBroStudio\DataRepository\Formatters\VatNumberFormatter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Mpociot\VatCalculator\Facades\VatCalculator;

class VatNumber extends ValueObject
{
    public readonly string $number;

    public readonly string $country;

    public function __construct(mixed $value)
    {
        parent::__construct(
            VatNumberFormatter::format($value)
        );

        $this->number = Str::of($this->value)
            ->substr(2)
            ->value();

        $this->country = Str::of($this->value)
            ->substr(0, 2)
            ->value();
    }

    public function authenticate(): VatNumberAuthenticationData
    {
        if ($this->country === 'GB') {
            throw new UnauthenticatableGBVatNumberException;
        }

        $validate = VatCalculator::getVATDetails($this->value);

        if (! $validate || ! $validate->valid) {
            throw new UnauthenticatedVatNumberException;
        }

        return VatNumberAuthenticationData::from($validate);
    }

    protected function validate(): void
    {
        if (! VatCalculator::isValidVatNumberFormat($this->value)) {
            throw ValidationException::withMessages(['VAT number is not valid.']);
        }
    }
}
