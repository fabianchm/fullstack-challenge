<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Application\Command\RemoveOrder;

use Finizens\Finance\Order\Application\Command\RemoveOrder\RemoveOrder;
use Finizens\Finance\Order\Application\Command\RemoveOrder\RemoveOrderHandler;
use Finizens\Finance\Order\Domain\Event\OrderRemoved;
use Finizens\Finance\Order\Domain\OrderRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DG\BypassFinals;
use Tests\Finance\Order\Domain\OrderMother;

final class RemoveOrderHandlerTest extends MockeryTestCase
{
    private RemoveOrderHandler $handler;
    private MockInterface $repository;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(OrderRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new RemoveOrderHandler($this->repository, $this->bus);
    } 

    public function test_removes_order(): void
    {
        $order = OrderMother::create();

        $command = new RemoveOrder($order->id());

        $this->repository->shouldReceive('searchById')->with($order->id())->andReturn($order);
        $this->repository->shouldReceive('remove')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof OrderRemoved;
            })
            ->once();

        call_user_func($this->handler, $command);
    } 

    public function test_do_nothing_if_order_not_found(): void
    {
        $command = new RemoveOrder(1);

        $this->repository->shouldReceive('searchById')->with(1)->andReturnNull();
        $this->repository->shouldNotReceive('remove');
        $this->bus->shouldNotReceive('dispatch');

        call_user_func($this->handler, $command);
    }
} 
