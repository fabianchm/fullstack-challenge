<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Application\Command;

use Finizens\Finance\Order\Application\Command\CreateOrder\CreateOrder;
use Finizens\Finance\Order\Application\Command\CreateOrder\CreateOrderHandler;
use Finizens\Finance\Order\Domain\Event\OrderCreated;
use Finizens\Finance\Order\Domain\OrderRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DG\BypassFinals;

final class CreateOrderHandlerTest extends MockeryTestCase
{
    private CreateOrderHandler $handler;
    private MockInterface $repository;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(OrderRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new CreateOrderHandler($this->repository, $this->bus);
    } 

    public function test_creates_order(): void
    {
        $command = new CreateOrder(
            id: 1,
            portfolio: 1,
            allocation: 1,
            shares: 5,
            type: "buy"
        );
 
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof OrderCreated;
            })
            ->once();

        call_user_func($this->handler, $command);
    } 
} 
