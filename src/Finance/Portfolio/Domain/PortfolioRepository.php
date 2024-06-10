<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

interface PortfolioRepository
{
    public function save(Portfolio $portfolio): void;

    public function searchById(int $id): ?Portfolio;
}
