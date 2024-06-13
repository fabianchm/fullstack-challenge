<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Application\Command\UpdateOrderCompleted;

use Finizens\Finance\Order\Application\Command\UpdateOrderCompleted\UpdateOrderCompleted;
use Finizens\Finance\Order\Application\Command\UpdateOrderCompleted\UpdateOrderCompletedHandler;
use Finizens\Finance\Order\Domain\Event\OrderCompleted;
use Finizens\Finance\Order\Domain\OrderRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use DG\BypassFinals;
use Tests\Finance\Order\Domain\OrderMother;

final class UpdateOrderCompletedHandlerTest extends MockeryTestCase
{
    private UpdateOrderCompletedHandler $handler;
    private MockInterface $repository;
    private MockInterface $bus;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(OrderRepository::class);
        $this->bus = Mockery::mock(MessageBusInterface::class);
        $this->handler = new UpdateOrderCompletedHandler($this->repository, $this->bus);
    } 

    public function test_do_nothing_if_order_is_already_completed(): void
    {
        $order = OrderMother::create(
            completed: true
        );

        $command = new UpdateOrderCompleted(
            id: $order->id(),
            status: "completed"
        );
 
        $this->repository->shouldReceive('searchById')
            ->with($order->id())
            ->andReturn($order);
        $this->repository->shouldNotReceive('save');
        $this->bus->shouldNotReceive('dispatch');

        call_user_func($this->handler, $command);
    } 

    public function test_updates_order_completed_status(): void
    {
        $order = OrderMother::create(completed: false);

        $command = new UpdateOrderCompleted(
            id: $order->id(),
            status: "completed"
        );
 
        $this->repository->shouldReceive('searchById')
            ->with($order->id())
            ->andReturn($order);
        $this->repository->shouldReceive('save')->once();
        $this->bus
            ->shouldReceive('dispatch')
            ->withArgs(function($arg) {
                return $arg instanceof OrderCompleted;
            })
            ->once();

        call_user_func($this->handler, $command);
    }
} 
