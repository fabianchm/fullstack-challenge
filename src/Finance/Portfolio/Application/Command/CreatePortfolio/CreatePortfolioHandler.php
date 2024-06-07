<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Application\Command\CreatePortfolio;

use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Finizens\Shared\Application\MessageHandler\CommandHandler;
use Symfony\Component\Messenger\MessageBusInterface;

class CreatePortfolioHandler implements CommandHandler
{
    public function __construct(
        private PortfolioRepository $repository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreatePortfolio $command): void
    {
        # TODO: 
        #   if portfolio already exists:
        #       - remove all allocations from this portfolio 
        #       - call a service to remove related orders
        
        $portfolio = Portfolio::create($command->id, $command->allocations);

        $this->repository->save($portfolio);

        $this->eventBus->dispatch(...$portfolio->pullDomainEvents());
    }
}
