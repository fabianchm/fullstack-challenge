<?php

namespace Finizens\Shared\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../../../../config/{routes}/' . $this->getEnvironment() . '/*.yaml');
        $routes->import('../../../../config/{routes}/*.yaml');

        if (is_file(dirname(__DIR__, 4) . '/config/routes.yaml')) {
            $routes->import('../../../../config/routes.yaml');
        }
    }
}
