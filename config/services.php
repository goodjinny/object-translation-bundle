<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Goodjinny\ObjectTranslationBundle\Command\ObjectTranslationExportCommand;
use Goodjinny\ObjectTranslationBundle\Command\ObjectTranslationImportCommand;
use Goodjinny\ObjectTranslationBundle\Command\ObjectTranslationWarmupCommand;
use Goodjinny\ObjectTranslationBundle\ObjectTranslator;
use Goodjinny\ObjectTranslationBundle\TranslatableMappingManager;
use Goodjinny\ObjectTranslationBundle\Twig\ObjectTranslatorExtension;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set('goodjinny.object_translator', ObjectTranslator::class)
            ->args([
                service('translation.locale_switcher'),
                param('kernel.default_locale'),
                service('.goodjinny.object_translator.mapping_manager'),
            ])
            ->tag('twig.runtime')
        ->alias(ObjectTranslator::class, 'goodjinny.object_translator')

        ->set('.goodjinny.object_translator.mapping_manager', TranslatableMappingManager::class)
        ->args([
            abstract_arg('translation class'),
            service('doctrine'),
        ])

        ->set('.goodjinny.object_translator.twig_extension', ObjectTranslatorExtension::class)
        ->tag('twig.extension')

        ->set('.goodjinny.object_translator.warmup_command', ObjectTranslationWarmupCommand::class)
            ->args([
                service('goodjinny.object_translator'),
                service('.goodjinny.object_translator.mapping_manager'),
                service('translation.locale_switcher'),
                param('kernel.enabled_locales'),
            ])
            ->tag('console.command')

        ->set('.goodjinny.object_translator.export_command', ObjectTranslationExportCommand::class)
            ->args([
                service('.goodjinny.object_translator.mapping_manager'),
            ])
            ->tag('console.command')

        ->set('.goodjinny.object_translator.import_command', ObjectTranslationImportCommand::class)
            ->args([
                service('.goodjinny.object_translator.mapping_manager'),
            ])
            ->tag('console.command')
    ;
};
