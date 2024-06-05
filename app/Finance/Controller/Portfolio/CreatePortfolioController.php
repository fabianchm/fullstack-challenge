<?php

declare(strict_types=1);

namespace App\Finance\Controller\Portfolio;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePortfolioController 
{
    public function __construct()
    {
    }
    
    #[Route(
        path: '/portfolios',
        name: 'portfolios.get',
        methods: ['GET']
    )]
    public function __invoke(): JsonResponse 
    {
        return new JsonResponse();
    }
}
