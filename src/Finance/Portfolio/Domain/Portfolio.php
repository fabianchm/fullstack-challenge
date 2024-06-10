<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationsAdded;
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
        $portfolio = new self($id, new PortfolioAllocationCollection($id, []));

        $portfolio->record(new PortfolioCreated($id));

        $portfolio->addAllocations($allocations);

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

    public function addAllocations(array $allocations): void
    {
        if (count($allocations) <= 0) {
            return;
        }

        foreach ($allocations as $allocation) {
            $this->allocations->addAllocation($allocation);
        }

        $this->record(new PortfolioAllocationsAdded($this->id, $allocations));
    }

    public function clearAllocations(): void
    {
        $this->allocations->clear();
    }
}
