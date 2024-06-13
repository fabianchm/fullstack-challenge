<?php

declare(strict_types=1);

namespace Tests\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Allocation;
use Tests\Shared\Domain\ObjectMother;

final class AllocationMother extends ObjectMother
{
    public static function create(
        ?int $id = null, 
        ?int $shares = null
    ): Allocation {
        return new Allocation(
            $id ?? self::generator()->numberBetween(),
            $shares ?? self::generator()->numberBetween(),
        );  
    }
}
