<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Infrastructure\Persistence\Doctrine;

use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Finizens\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class PortfolioDoctrineRepository extends DoctrineRepository implements PortfolioRepository
{
    public function entityClassName(): string
    {
        return Portfolio::class;
    }

    public function save(Portfolio $portfolio): void
    {
        $this->persistAggregateRoot($portfolio);
    }

    public function searchById(int $id): ?Portfolio
    {
        return $this->repository()->findOneBy(['id' => $id]);
    }
}

