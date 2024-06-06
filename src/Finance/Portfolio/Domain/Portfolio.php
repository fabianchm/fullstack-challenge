<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Shared\Domain\Aggregate\AggregateRoot;

class Portfolio implements AggregateRoot
{
    public function __construct(
        private int $id,
    ) {
    }

    public static function create(
        int $id,
    ): self {
        return new self($id);
    }
}
