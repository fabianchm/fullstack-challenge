<?php

declare(strict_types=1);

namespace Tests\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioAllocationCollection;
use Tests\Shared\Domain\ObjectMother;

final class PortfolioMother extends ObjectMother
{
    public static function create(
        ?int $id = null, 
        ?PortfolioAllocationCollection $allocations = null
    ): Portfolio {
        $portfolioId = $id ?? self::generator()->numberBetween();
        return new Portfolio(
            $portfolioId,
            $allocations ?? PortfolioAllocationCollectionMother::create($portfolioId)
        );  
    }

}
