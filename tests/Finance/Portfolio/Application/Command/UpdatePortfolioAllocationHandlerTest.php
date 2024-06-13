<?php

namespace Tests\Finance\Portfolio\Application\Command;

use DG\BypassFinals;
use Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted\UpdatePortfolioAllocation;
use Finizens\Finance\Portfolio\Application\Command\UpdatePortfolioAllocationsFromOrderCompleted\UpdatePortfolioAllocationHandler;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationRemoved;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationSharesUpdated;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationsAdded;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Tests\Finance\Portfolio\Domain\AllocationMother;
use Tests\Finance\Portfolio\Domain\PortfolioAllocationCollectionMother;
use Tests\Finance\Portfolio\Domain\PortfolioMother;

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
        $portfolio = PortfolioMother::create(
            id: 1,
            allocations: PortfolioAllocationCollectionMother::create(
                id: 1,
                allocations: [
                    AllocationMother::create(
                        id: 1,
                        shares: 3
                    )->serialize()
                ]
            )
        );


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
        $portfolio = PortfolioMother::create(
            id: 1,
            allocations: PortfolioAllocationCollectionMother::create(
                id: 1,
                allocations: [
                    AllocationMother::create(
                        id: 1,
                        shares: 3
                    )->serialize()
                ]
            )
        );

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
        $portfolio = PortfolioMother::create(
            id: 1,
            allocations: PortfolioAllocationCollectionMother::create(
                id: 1,
                allocations: [
                    AllocationMother::create(
                        id: 1,
                        shares: 3
                    )->serialize()
                ]
            )
        );

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
        $portfolio = PortfolioMother::create(
            id: 1,
            allocations: PortfolioAllocationCollectionMother::create(
                id: 1,
                allocations: []
            )
        );

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
