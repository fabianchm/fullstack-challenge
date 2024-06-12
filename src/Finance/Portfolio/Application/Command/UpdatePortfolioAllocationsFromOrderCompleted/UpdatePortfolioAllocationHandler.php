<?php

namespace Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted;

use Finizens\Finance\Portfolio\Domain\Allocation;
use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdatePortfolioAllocationHandler implements CommandHandler
{
    public function __construct(
        private PortfolioRepository $repository,
        private MessageBusInterface $eventBus
    ) {
    }

    public function __invoke(UpdatePortfolioAllocation $command): void {
        $portfolio = $this->repository->searchById($command->portfolioId);

        if ($portfolio === null) {
            return;
        }

        $allocation = $portfolio->findAllocation($command->allocationId);

        if ($allocation === null && $command->orderType === "sell") {
            return;
        }

        match ($command->orderType) {
            "sell" => $this->sellShares($portfolio, $allocation, $command->shares),
            "buy" => $this->buyShares($portfolio, $allocation, $command->allocationId,  $command->shares),
        };
        
        $this->repository->save($portfolio); 
        
        $this->eventBus->dispatch(...$portfolio->pullDomainEvents());
    }

    private function sellShares(Portfolio $portfolio, Allocation $allocation, int $shares): void
    {
        if ($allocation->shares() <= $shares) {
            $portfolio->removeAllocation($allocation->id()); 
            return;
        }
       
        $portfolio->removeAllocationShares($allocation->id(), $shares);
    }

    private function buyShares(Portfolio $portfolio, ?Allocation $allocation, int $allocationId, int $shares): void
    {
        if ($allocation === null) {
            $portfolio->addAllocations([['id' => $allocationId, 'shares' => $shares]]);
            return;
        }

        $portfolio->addAllocationShares($allocation->id(), $shares);
    }
}
