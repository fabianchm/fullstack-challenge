<?php

declare(strict_types=1);

namespace Tests\Finance\Application\Query;

use Finizens\Finance\Portfolio\Application\Query\SearchPortfolioById;
use Finizens\Finance\Portfolio\Application\Query\SearchPortfolioByIdHandler;
use Finizens\Finance\Portfolio\Application\Query\View\AllocationViewAssembler;
use Finizens\Finance\Portfolio\Application\Query\View\PortfolioView;
use Finizens\Finance\Portfolio\Application\Query\View\PortfolioViewAssembler;
use Finizens\Finance\Portfolio\Domain\Portfolio;
use Finizens\Finance\Portfolio\Domain\PortfolioRepository;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use DG\BypassFinals;

final class SearchPortfolioByIdHandlerTest extends MockeryTestCase
{
    private SearchPortfolioByIdHandler $handler;
    private MockInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        BypassFinals::enable();

        $this->repository = Mockery::mock(PortfolioRepository::class);
        $this->handler = new SearchPortfolioByIdHandler(
            $this->repository, 
            new PortfolioViewAssembler(
                new AllocationViewAssembler()
            )
        );
    } 

    public function test_returns_null_if_not_found(): void
    {
        $query = new SearchPortfolioById(1); 
        
        $this->repository->shouldReceive('searchById')->andReturns(null);

        $response = call_user_func($this->handler, $query);

        self::assertNull($response);
    } 

    public function test_resturns_view_if_found(): void
    {
        $view = new PortfolioView(1, []);

        $query = new SearchPortfolioById($view->id); 
    
        $this->repository->shouldReceive('searchById')->andReturns(Portfolio::create($view->id, []));

        $response = call_user_func($this->handler, $query);

        self::assertEquals($response, $view);
    }
} 
