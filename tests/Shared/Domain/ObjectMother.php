<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Faker\Factory;
use Faker\Generator;

abstract class ObjectMother
{
    public static ?Generator $generator = null;

    public static function generator(): Generator
    {
        return self::$generator = self::$generator ?? Factory::create('en_EN');
    }
}
