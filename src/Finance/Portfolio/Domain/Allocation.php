<?php

namespace Finizens\Finance\Portfolio\Domain;

use Finizens\Shared\Domain\Aggregate\Entity;

class Allocation implements Entity
{
    public function __construct(private int $id, private int $shares)
    {
    }

    public static function create(int $id, int $shares): self
    {
        return new self($id, $shares);
    }
    
    public function id(): int
    {
        return $this->id;
    }

    public function shares(): int
    {
        return $this->shares;
    }

    public function addShares(int $shares): void
    {
        $this->shares += $shares;
    }

    public function removeShares(int $shares): void
    {
        $this->shares -= $shares;
    }
}
