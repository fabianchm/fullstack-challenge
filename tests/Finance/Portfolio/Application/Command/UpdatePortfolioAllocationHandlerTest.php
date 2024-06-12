<?php

namespace Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted;

use DG\BypassFinals;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationRemoved;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationSharesUpdated;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationsAdded;
use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioAllocationCollection;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class UpdatePortfolioAllocationHandlerTest extends MockeryTestCase 
{
    private UpdatePortfolioAllocationHandler $handler;
    private MockInterface $repository;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(PortfolioRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new UpdatePortfolioAllocationHandler($this->repository, $this->bus);
    } 

    public function test_remove_allocation_if_sell_all_shares(): void
    {
        $portfolio = new Portfolio(1, new PortfolioAllocationCollection(1, [
            [
                'id' => 1,
                'shares' => 3,
            ]
        ]));

        $command = new UpdatePortfolioAllocation(1, 1, 3, "sell");
 
        $this->repository->shouldReceive('searchById')->andReturns($portfolio);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioAllocationRemoved;
            })
            ->once();

        call_user_func($this->handler, $command);
    }


    public function test_remove_shares_when_sell_order_is_completed(): void
    {
        $portfolio = new Portfolio(1, new PortfolioAllocationCollection(1, [
            [
                'id' => 1,
                'shares' => 3,
            ]
        ]));

        $command = new UpdatePortfolioAllocation(1, 1, 2, "sell");
 
        $this->repository->shouldReceive('searchById')->andReturns($portfolio);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioAllocationSharesUpdated;
            })
            ->once();

        call_user_func($this->handler, $command);

        self::assertEquals(1, $portfolio->findAllocation(1)->shares());
    }

    
    public function test_add_shares_when_buy_order_is_completed(): void
    {
        $portfolio = new Portfolio(1, new PortfolioAllocationCollection(1, [
            [
                'id' => 1,
                'shares' => 3,
            ]
        ]));

        $command = new UpdatePortfolioAllocation(1, 1, 2, "buy");
 
        $this->repository->shouldReceive('searchById')->andReturns($portfolio);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioAllocationSharesUpdated;
            })
            ->once();

        call_user_func($this->handler, $command);

        self::assertEquals(5, $portfolio->findAllocation(1)->shares());
    }


    public function test_creates_allocation_if_not_exists_when_buy_order_is_completed(): void
    {
        $portfolio = new Portfolio(1, new PortfolioAllocationCollection(1, []));

        $command = new UpdatePortfolioAllocation(1, 1, 2, "buy");
 
        $this->repository->shouldReceive('searchById')->andReturns($portfolio);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioAllocationsAdded;
            })
            ->once();

        call_user_func($this->handler, $command);

        self::assertNotNull($portfolio->findAllocation(1));
    }
}
