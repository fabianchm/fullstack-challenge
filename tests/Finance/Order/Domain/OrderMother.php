<?php

declare(strict_types=1);

namespace Tests\Finance\Order\Domain;

use Finizens\Finance\Order\Domain\Order;
use Finizens\Finance\Shared\Domain\OrderTypeEnum;
use Tests\Shared\Domain\ObjectMother;

final class OrderMother extends ObjectMother
{
    public static function create(
        ?int $id = null, 
        ?int $portfolio = null, 
        ?int $allocation = null, 
        ?int $shares = null, 
        ?string $type = null, 
        ?bool $completed = null, 
    ): Order {
        return new Order(
            $id ?? self::generator()->numberBetween(),
            $portfolio ?? self::generator()->numberBetween(),
            $allocation ?? self::generator()->numberBetween(),
            $shares ?? self::generator()->numberBetween(),
            $type ?? self::generateType(),
            $completed ?? self::generator()->boolean(),
        );  
    }

    public static function generateType(): string
    {
        return self::generator()->boolean() === true ? OrderTypeEnum::BUY : OrderTypeEnum::SELL;
    }
}
