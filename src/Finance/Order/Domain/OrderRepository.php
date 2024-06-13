<?php

declare(strict_types=1);

namespace Finizens\Finance\Order\Domain;

use Finizens\Finance\Order\Domain\Order;

interface OrderRepository
{
    public function save(Order $order): void;

    public function searchById(int $id): ?Order;

    public function remove(Order $order): void;

    public function searchAllByPortfolioId(int $portfolioId): array;

    public function searchUncompletedByPortfolioId(int $portfolioId): array;
}
