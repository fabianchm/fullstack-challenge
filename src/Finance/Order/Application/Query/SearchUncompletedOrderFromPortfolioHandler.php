<?php

namespace Finizens\Finance\Order\Application\Query;

use Finizens\Finance\Order\Application\Query\View\OrderListView;
use Finizens\Finance\Order\Application\Query\View\OrderListViewAssembler;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Shared\Application\MessageHandler\QueryHandler;

final class SearchUncompletedOrderFromPortfolioHandler implements QueryHandler
{
    public function __construct(
        private OrderRepository $repository,
        private OrderListViewAssembler $listViewAssembler
    ) {
    }

    public function __invoke(SearchUncompletedOrderFromPortfolio $query): OrderListView
    {
        $orders = $this->repository->searchUncompletedByPortfolioId($query->portfolioId);

        return $this->listViewAssembler->invoke($orders); 
    }
}
