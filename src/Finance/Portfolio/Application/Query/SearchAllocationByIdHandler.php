<?php

namespace Finizens\Finance\Portfolio\Application\Query;

use Finizens\Finance\Portfolio\Application\Query\View\PortfolioView;
use Finizens\Finance\Portfolio\Application\Query\View\PortfolioViewAssembler;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Finizens\Finance\Shared\Application\Query\SearchAllocationById;
use Finizens\Shared\Application\MessageHandler\QueryHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class SearchAllocationByIdHandler implements QueryHandler
{
    public function __construct(
        private PortfolioRepository $repository,
        private PortfolioViewAssembler $viewAssembler
    ) {
    }

    public function __invoke(SearchAllocationById $query): ?PortfolioView
    {
        $portfolio = $this->repository->searchById($query->portfolioId);

        if ($portfolio === null) {
            throw new HttpException(statusCode: 404);
        }

        $allocation = $portfolio->findAllocation($query->allocationId);

        if ($allocation === null) {
            throw new HttpException(statusCode: 404);
        }

        return $this->viewAssembler->invoke($portfolio); 
    }
}
