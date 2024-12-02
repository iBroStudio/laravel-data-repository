<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Bakame\Laravel\Pdp\Facades\DomainParser;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\ValueObject;
use Pdp;

class Domain extends ValueObject
{
    private Pdp\ResolvedDomainName $domain;

    public function __construct(Pdp\Host|string $value)
    {
        $topLevelDomains = DomainParser::getTopLevelDomains();

        $this->domain = $topLevelDomains->resolve($value);

        $this->validate();
    }

    public function value(): string
    {
        return $this->domain->domain()->toString();
    }

    public function subDomain(): string
    {
        return $this->domain->subDomain()->toString();
    }

    public function name(): string
    {
        return $this->domain->secondLevelDomain()->toString();
    }

    public function tld(): string
    {
        return $this->domain->suffix()->toString();
    }

    public function registrable(): string
    {
        return $this->domain->registrableDomain()->toString();
    }

    protected function validate(): void
    {
        if (! $this->domain->suffix()->isICANN() && ! $this->domain->suffix()->isIANA()) {
            throw ValidationException::withMessages(['Value is not a valid domain.']);
        }
    }
}
