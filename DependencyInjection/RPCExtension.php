<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RPCExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator());
        $finder = new Finder();

        $configPaths[] = __DIR__ . '/../Resources/config';

        foreach ($configPaths as $ymlPath) {

            $files = $finder->files()->in($ymlPath)->name('*.yml')->notName('routing*');

            foreach ($files as $file) {
                /** @var $file \Symfony\Component\Finder\SplFileInfo */
                $loader->load($file->getPathname());
            }
        }


        $container->setParameter('mo.rpc.tag_name', $config['tag_name']);
        $container->setParameter('mo.rpc.container_service', $config['container_service']);
    }
}
