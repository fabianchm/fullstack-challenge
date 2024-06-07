<?php

declare(strict_types=1);

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Finance\Portfolio\Domain\Event\PortfolioCreated;
use Finizens\Shared\Domain\Aggregate\DataSourceRoot;

class Portfolio extends DataSourceRoot
{
    public function __construct(
        private int $id,
    ) {
    }

    public static function create(
        int $id,
    ): self {
        $portfolio = new self($id);

        $portfolio->record(new PortfolioCreated($id));

        return $portfolio;
    }
}
