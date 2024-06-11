<?php

declare(strict_types=1);

namespace Tests\Finance\Portfolio\Application\Command;

use Finizens\Finance\Portfolio\Application\Command\CreatePortfolio\CreatePortfolio;
use Finizens\Finance\Portfolio\Application\Command\CreatePortfolio\CreatePortfolioHandler;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioAllocationsAdded;
use Finizens\Finance\Portfolio\Domain\Event\PortfolioCreated;
use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioAllocationCollection;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DG\BypassFinals;

final class CreatePortfolioHandlerTest extends MockeryTestCase
{
    private CreatePortfolioHandler $handler;
    private MockInterface $repository;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(PortfolioRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new CreatePortfolioHandler($this->repository, $this->bus);
    } 

    public function test_creates_portfolio(): void
    {
        $command = new CreatePortfolio(1, []);
 
        $this->repository->shouldReceive('searchById')->andReturns(null);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioCreated;
            })
            ->once();

        call_user_func($this->handler, $command);
    } 

    public function test_add_allocations_if_portfolio_already_exists(): void
    {
        $command = new CreatePortfolio(1, [['id' => 1, 'shares' => 8]]);
        $portfolio = new Portfolio(
            1, 
            new PortfolioAllocationCollection(1, [
                ['id' => 1, 'shares' => 7]                
            ])
        );
 
        $this->repository->shouldReceive('searchById')->andReturns($portfolio);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof PortfolioAllocationsAdded;
            })
            ->once();

        call_user_func($this->handler, $command);
        
        self::assertEquals($portfolio->allocations()[1]->shares(), 8);
    }
} 
