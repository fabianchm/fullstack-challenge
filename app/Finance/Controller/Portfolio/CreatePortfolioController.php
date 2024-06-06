<?php

declare(strict_types=1);

namespace App\Finance\Controller\Portfolio;

use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePortfolioController 
{
    public function __construct(private PortfolioRepository $repository)
    {
    }
    
    #[Route(
        path: '/portfolios/{id}',
        name: 'portfolios.put',
        methods: ['PUT']
    )]
    public function __invoke(int $id): JsonResponse 
    {
        $p = Portfolio::create($id);
        $this->repository->save($p);        
        return new JsonResponse($id);
    }
}
