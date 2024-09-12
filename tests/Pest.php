<?php

use IBroStudio\DataRepository\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class)->in(__DIR__);

function getProperty(object $object, string $property)
{
    $reflectedClass = new \ReflectionClass($object);

    $reflection = $reflectedClass->getProperty($property);

    $reflection->setAccessible(true);

    return $reflection->getValue($object);
}
