<?php

declare(strict_types=1);

namespace Tests\Shared\Integration\Persistence\Doctrine;

use Finizens\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineRepositoryTestAggregateRootRepository extends DoctrineRepository
{
    public function entityClassName(): string
    {
        return DoctrineRepositoryTestAggregateRoot::class;
    }

    public function search(int $id): ?DoctrineRepositoryTestAggregateRoot
    {
        return $this->repository()->find($id);
    }

    public function persist(DoctrineRepositoryTestAggregateRoot $aggregateRoot): void
    {
        $this->persistAggregateRoot($aggregateRoot);
    }

    public function remove(DoctrineRepositoryTestAggregateRoot $aggregateRoot): void
    {
        $this->removeAggregateRoot($aggregateRoot);
    }
}

