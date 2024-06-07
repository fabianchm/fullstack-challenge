<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Application\Command\CreatePortfolio;

use Finizens\Shared\Application\MessageHandler\Command;

class CreatePortfolio implements Command
{
    public function __construct(public int $id, public array $allocations)
    {
    }
}
