<?php

declare(strict_types=1);

namespace Tests\Finance\Application\Command;

use Finizens\Finance\Portfolio\Application\Command\CreatePortfolio\CreatePortfolio;
use Finizens\Finance\Portfolio\Application\Command\CreatePortfolio\CreatePortfolioHandler;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use function PHPUnit\Framework\anything;
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
        
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->with(anything())
            ->once();

        call_user_func($this->handler, $command);
    } 
} 
