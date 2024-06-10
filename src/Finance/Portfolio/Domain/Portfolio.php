<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Event\PortfolioCreated;
use Finizens\Shared\Domain\Aggregate\DataSourceRoot;

class Portfolio extends DataSourceRoot
{
    public function __construct(
        private int $id,
        private PortfolioAllocationCollection $allocations
    ) {
    }

    public static function create(
        int $id,
        array $allocations
    ): self {
        $portfolio = new self($id, new PortfolioAllocationCollection($id, $allocations));

        $portfolio->record(new PortfolioCreated($id));

        return $portfolio;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function allocations(): array
    {
        return $this->allocations->getArray();
    }
}
