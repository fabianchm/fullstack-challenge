<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\UpdateOrderCompleted;

use Finizens\Shared\Application\MessageHandler\Command;

class UpdateOrderCompleted implements Command
{
    public function __construct(
        public int $id,
        public string $status
    ) {
    }
}
