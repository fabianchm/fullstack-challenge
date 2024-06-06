<?php

declare(strict_types=1);

namespace Finizens\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Finizens\Shared\Domain\Aggregate\AggregateRoot;

abstract class DoctrineRepository
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {
    }

    abstract public function entityClassName(): string;

    protected function manager(): EntityManager
    {
        return $this->managerRegistry->getManager();
    }

    protected function repository(): EntityRepository
    {
        return $this->manager()->getRepository($this->entityClassName());
    }

    protected function persistAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        $this->manager()->wrapInTransaction(
            function () use ($aggregateRoot): void {
                $this->manager()->persist($aggregateRoot);
            }
        );
    }

    protected function removeAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        $this->manager()->wrapInTransaction(
            function () use ($aggregateRoot): void {
                $this->manager()->remove($aggregateRoot);
            }
        );
    }
}
