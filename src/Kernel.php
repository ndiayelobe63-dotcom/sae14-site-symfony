<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        // Load routes from config/routes/*.yaml and config/routes.yaml
        $routes->import($confDir.'/{routes}/*.{php,yaml}');
        $routes->import($confDir.'/{routes}.{php,yaml}');

        // IMPORTANT: load routes defined with #[Route] in Controllers
        $routes->import($this->getProjectDir().'/src/Controller/', 'attribute');
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $confDir = $this->getProjectDir().'/config';

        $container->import($confDir.'/{packages}/*.yaml');
        $container->import($confDir.'/{packages}/'.$this->environment.'/*.yaml');
        $container->import($confDir.'/{services}.yaml');
        $container->import($confDir.'/{services}_'.$this->environment.'.yaml');
    }
}
