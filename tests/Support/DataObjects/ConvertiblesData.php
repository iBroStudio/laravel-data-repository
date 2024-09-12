<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use IBroStudio\DataRepository\Concerns\ConvertiblesDataProperties;
use IBroStudio\DataRepository\Enums\Countries;
use IBroStudio\DataRepository\Enums\Currencies;
use IBroStudio\DataRepository\Enums\Timezones;
use IBroStudio\DataRepository\ValueObjects;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class ConvertiblesData extends Data
{
    use ConvertiblesDataProperties;

    public function __construct(
        public string $string,
        public ValueObjects\Text $text,
        public ValueObjects\Boolean $boolean,
        public ValueObjects\Number $number,
        public ValueObjects\ClassString $classString,
        public ValueObjects\Email $email,
        public ValueObjects\EncryptableText $encryptableText,
        public ValueObjects\FullName $fullName,
        public ValueObjects\HashedPassword $hashedPassword,
        public ValueObjects\Name $name,
        public ValueObjects\Phone $phone,
        public ValueObjects\TaxNumber $taxNumber,
        public ValueObjects\Timecode $timecode,
        public ValueObjects\Uri $uri,
        public ValueObjects\Url $url,
        public ValueObjects\Uuid $uuid,
        public OtherReferableData $simpleLaravelData,
        public WithEncryptableTextData $withValueObjectLaravelData,
        public NestedData $nestedData,
        #[DataCollectionOf(OtherReferableData::class)]
        public Collection $simpleCollection,
        #[DataCollectionOf(WithEncryptableTextData::class)]
        public Collection $withValueObjectCollection,
        #[DataCollectionOf(NestedData::class)]
        public Collection $nestedDataCollection,
        public Countries $countryEnum,
        public Currencies $currencyEnum,
        public Timezones $timezoneEnum,
    ) {}
}
