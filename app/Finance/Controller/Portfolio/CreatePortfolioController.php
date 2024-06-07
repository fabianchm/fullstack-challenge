<?php

declare(strict_types=1);

namespace App\Finance\Controller\Portfolio;

use Finizens\Finance\Portfolio\Application\Command\CreatePortfolio\CreatePortfolio;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePortfolioController 
{
    public function __construct(private MessageBusInterface $bus)
    {
    }
    
    #[Route(
        path: '/portfolios/{id}',
        name: 'portfolios.put',
        methods: ['PUT']
    )]
    public function __invoke(int $id): JsonResponse 
    {
        $this->bus->dispatch(new CreatePortfolio($id));

        return new JsonResponse();
    }
}
