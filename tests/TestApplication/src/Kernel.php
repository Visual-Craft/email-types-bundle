<?php

declare(strict_types=1);

namespace VisualCraft\EmailTypesBundle\Tests\TestApplication;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use VisualCraft\EmailTypesBundle\Mailer;
use VisualCraft\EmailTypesBundle\VisualCraftEmailTypesBundle;

final class Kernel extends SymfonyKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', false);
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new VisualCraftEmailTypesBundle(),
        ];
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/com.github.visual-craft.email-types-bundle/tests/var/' . $this->environment . '/cache';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/com.github.visual-craft.email-types-bundle/tests/var/' . $this->environment . '/log';
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition(Mailer::class)->setPublic(true);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir() . '/config/{packages}/*.php', 'glob');
        $loader->load($this->getProjectDir() . '/config/{packages}/' . $this->environment . '/*.php', 'glob');
        $loader->load($this->getProjectDir() . '/config/{services}.php', 'glob');
        $loader->load($this->getProjectDir() . '/config/{services}_' . $this->environment . '.php', 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
    }
}
