<?php

namespace Finizens\Finance\Portfolio\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Finizens\Shared\Domain\Aggregate\Entity;

class PortfolioAllocationCollection implements Entity
{
    private Collection $allocations;

    public function __construct(private int $portfolioId, array $allocations)
    {
        $this->allocations = new ArrayCollection();

        foreach ($allocations as $allocation) {
            $this->addAllocation($allocation);
        }
    }

    public function addAllocation(array $allocationData): void
    {
        $allocation = Allocation::create($allocationData['id'], $allocationData['shares']);
        $this->allocations->set($allocation->id(), $allocation);
    }

    public function getArray(): array
    {
        return $this->allocations->toArray();
    }

    public function clear(): void
    {
        $this->allocations->clear();
    }
}
