<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Application\Query;

use Finizens\Finance\Order\Application\Query\SearchUncompletedOrderFromPortfolio;
use Finizens\Finance\Order\Application\Query\SearchUncompletedOrderFromPortfolioHandler;
use Finizens\Finance\Order\Application\Query\View\OrderListView;
use Finizens\Finance\Order\Application\Query\View\OrderListViewAssembler;
use Finizens\Finance\Order\Application\Query\View\OrderView;
use Finizens\Finance\Order\Application\Query\View\OrderViewAssembler;
use Finizens\Finance\Order\Domain\Order;
use Finizens\Finance\Order\Domain\OrderRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use DG\BypassFinals;

final class SearchUncompletedOrderFromPortfolioHandlerTest extends MockeryTestCase
{
    private SearchUncompletedOrderFromPortfolioHandler $handler;
    private MockInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(OrderRepository::class);
        $this->handler = new SearchUncompletedOrderFromPortfolioHandler(
            $this->repository, 
            new OrderListViewAssembler(
                new OrderViewAssembler()
            )
        );
    } 

    public function test_resturns_view(): void
    {
        $view = new OrderView(1, 1, 1, 1, "sell", false);
        $viewList = new OrderListView([$view]);

        $query = new SearchUncompletedOrderFromPortfolio($view->id); 
    
        $this->repository->shouldReceive('searchUncompletedByPortfolioId')->andReturns(
            [Order::create($view->id, 1, 1, 1, "sell", false)]
        );

        $response = call_user_func($this->handler, $query);

        self::assertEquals($response, $viewList);
    }
} 
