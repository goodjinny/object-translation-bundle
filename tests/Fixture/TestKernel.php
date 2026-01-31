<?php

namespace Goodjinny\ObjectTranslationBundle\Tests\Fixture;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Goodjinny\ObjectTranslationBundle\ObjectTranslationBundle;
use Goodjinny\ObjectTranslationBundle\Tests\Fixture\Entity\Translation;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Zenstruck\Foundry\ZenstruckFoundryBundle;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new DoctrineBundle();
        yield new ZenstruckFoundryBundle();
        yield new ObjectTranslationBundle();
    }

    private function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $container->extension('framework', [
            'test' => true,
        ]);

        $builder->loadFromExtension('goodjinny_object_translation', [
            'translation_class' => Translation::class,
        ]);

        $builder->loadFromExtension('doctrine', [
            'dbal' => [
                'url' => 'sqlite:///%kernel.project_dir%/var/data.db',
            ],
            'orm' => [
                'mappings' => [
                    'Test' => [
                        'dir' => '%kernel.project_dir%/tests/Fixture/Entity',
                        'prefix' => 'Goodjinny\ObjectTranslationBundle\Tests\Fixture\Entity',
                    ],
                ],
            ],
        ]);
    }
}
