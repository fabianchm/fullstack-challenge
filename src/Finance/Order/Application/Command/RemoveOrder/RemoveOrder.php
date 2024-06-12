<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\RemoveOrder;

use Finizens\Shared\Application\MessageHandler\Command;

class RemoveOrder implements Command
{
    public function __construct(public int $id) 
    {
    }
}
