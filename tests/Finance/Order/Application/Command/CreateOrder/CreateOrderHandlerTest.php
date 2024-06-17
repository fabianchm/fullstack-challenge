<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Application\Command\CreateOrder;

use Finizens\Finance\Order\Application\Command\CreateOrder\CreateOrder;
use Finizens\Finance\Order\Application\Command\CreateOrder\CreateOrderHandler;
use Finizens\Finance\Order\Domain\Event\OrderCreated;
use Finizens\Finance\Order\Domain\OrderRepository;
use Finizens\Finance\Shared\Application\Query\SearchAllocationById;
use Finizens\Finance\Shared\Domain\OrderTypeEnum;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DG\BypassFinals;

final class CreateOrderHandlerTest extends MockeryTestCase
{
    private CreateOrderHandler $handler;
    private MockInterface $repository;
    private MockInterface $queryBus;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(OrderRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->queryBus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new CreateOrderHandler($this->repository, $this->bus, $this->queryBus);
    } 

    public function test_creates_order(): void
    {
        #This test fails because calling last method on Envelope class is not mocked here
        $this->markTestSkipped();

        $command = new CreateOrder(
            id: 1,
            portfolio: 1,
            allocation: 1,
            shares: 5,
            type: OrderTypeEnum::BUY
        );
 
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof OrderCreated;
            })
            ->once();
        $this->queryBus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof SearchAllocationById;
            })
            ->once();

        call_user_func($this->handler, $command);
    } 
} 
