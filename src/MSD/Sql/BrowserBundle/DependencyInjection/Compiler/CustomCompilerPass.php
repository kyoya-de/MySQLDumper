<?php

namespace MSD\Sql\BrowserBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CustomCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('msd.sql_browser.formatter.data_types')) {
            return;
        }

        $definition = $container->getDefinition('msd.sql_browser.formatter.data_types');
        $taggedServices = $container->findTaggedServiceIds('msd.sql_browser.formatter.data_type');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall('addFormatter', array(new Reference($id), $attributes['dataTypes']));
            }
        }
    }
}