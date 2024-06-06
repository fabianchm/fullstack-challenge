<?php

declare(strict_types=1);

namespace Tests\Shared\Integration\Persistence\Doctrine;

use Finizens\Shared\Domain\Aggregate\AggregateRoot;

class DoctrineRepositoryTestAggregateRoot implements AggregateRoot
{
    public function __construct(private int $id)
    {
    }

    public function changeId(int $id): void
    {
        $this->id = $id;
    }
}
