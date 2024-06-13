<?php

declare(strict_types=1);

namespace Tests\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\PortfolioAllocationCollection;
use Tests\Shared\Domain\ObjectMother;

final class PortfolioAllocationCollectionMother extends ObjectMother
{
    public static function create(
        ?int $id = null,
        ?array $allocations = null
    ): PortfolioAllocationCollection {
        return new PortfolioAllocationCollection(
            $id ?? self::generator()->numberBetween(),
            $allocations ?? self::generateAllocations()
        );
    }

    public static function generateAllocations(): array
    {
        $allocations = [];

        for ($i = 0; $i < self::generator()->numberBetween(1, 5); $i++) {
            $allocations[] = AllocationMother::create();
        }

        return $allocations;
    }
}
