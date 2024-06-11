<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Application\Command\CreateOrder;

use Finizens\Shared\Application\MessageHandler\Command;

class CreateOrder implements Command
{
    public function __construct(
        public int $id,
        public int $portfolio,
        public int $allocation,
        public int $shares,
        public string $type
    ) {
    }
}
