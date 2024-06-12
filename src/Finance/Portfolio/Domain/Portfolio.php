<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationRemoved;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationSharesUpdated;
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

        $portfolio->addAllocations($allocations, true);

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

    public function addAllocations(array $allocations, bool $avoidDispatchEvent = false): void
    {
        if (count($allocations) <= 0) {
            return;
        }

        foreach ($allocations as $allocation) {
            $this->allocations->addAllocation($allocation);
        }

        if ($avoidDispatchEvent === false) {
            $this->record(new PortfolioAllocationsAdded($this->id, $allocations));
        }
    }

    public function clearAllocations(): void
    {
        $this->allocations->clear();
    }

    public function findAllocation(int $id): ?Allocation
    {
        return $this->allocations->find($id);
    }

    public function removeAllocation(int $id): void
    {
        $this->allocations->remove($id);

        $this->record(
            new PortfolioAllocationRemoved(
                id: $this->id,
                allocationId: $id 
            )
        );
    }

    public function removeAllocationShares(int $id, int $shares): void
    {
        $allocation = $this->findAllocation($id);
        $oldShares = $allocation->shares();
        $allocation->removeShares($shares);

        $this->record(new PortfolioAllocationSharesUpdated(
            id: $this->id,
            allocationId: $id,
            oldShares: $oldShares,
            newShares: $allocation->shares()
        ));
    }

    
    public function addAllocationShares(int $id, int $shares): void
    {
        $allocation = $this->findAllocation($id);
        $oldShares = $allocation->shares();
        $allocation->addShares($shares);

        $this->record(new PortfolioAllocationSharesUpdated(
            id: $this->id,
            allocationId: $id,
            oldShares: $oldShares,
            newShares: $allocation->shares()
        ));
    }
}
