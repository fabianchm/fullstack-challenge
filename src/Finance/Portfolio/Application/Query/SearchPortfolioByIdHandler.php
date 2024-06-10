<?php

namespace Finizens\Finance\Portfolio\Application\Query;

use Finizens\Finance\Portfolio\Application\Query\View\PortfolioView;
use Finizens\Finance\Portfolio\Application\Query\View\PortfolioViewAssembler;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Finizens\Shared\Application\MessageHandler\QueryHandler;

final class SearchPortfolioByIdHandler implements QueryHandler
{
    public function __construct(
        private PortfolioRepository $repository,
        private PortfolioViewAssembler $viewAssembler
    ) {
    }

    public function __invoke(SearchPortfolioById $query): ?PortfolioView
    {
        $portfolio = $this->repository->searchById($query->id);

        if ($portfolio === null) {
            return null;
        }

        return $this->viewAssembler->invoke($portfolio); 
    }
}
