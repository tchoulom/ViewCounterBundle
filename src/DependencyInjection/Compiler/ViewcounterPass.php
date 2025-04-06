<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@gmail.com>
 *
 * (c) Ernest TCHOULOM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tchoulom\ViewCounterBundle\TchoulomViewCounterBundle;

/**
 * Class ViewcounterPass.
 */
class ViewcounterPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('tchoulom_view_counter');

        $viewcounterNode = $configs[0]['view_counter'];
        $statsNode = $configs[0]['statistics'];
        $storageNode = $configs[0]['storage'] ?? null;
        $geolocationNode = $configs[0]['geolocation'] ?? null;

        $viewcounterNodeDefinition = $container->getDefinition('tchoulom.viewcounter_node_config');
        $statisticsNodeDefinition = $container->getDefinition('tchoulom.statistics_node_config');

        $viewcounterNodeDefinition->replaceArgument(0, $viewcounterNode);
        $statisticsNodeDefinition->replaceArgument(0, $statsNode);

        if (isset($storageNode['engine'])) {
            $storerDefinition = $this->getStorageEngineDefinition($container, $storageNode['engine']);

            $storageAdapterDefinition = $container->getDefinition('tchoulom.viewcounter.storage_adapter');
            $storageAdapterDefinition->replaceArgument(0, $storerDefinition);

            $statsConverterDefinition = $container->getDefinition('tchoulom.viewcounter.stats_converter');
            $statsConverterDefinition->replaceArgument(0, $storerDefinition);

            if (TchoulomViewCounterBundle::MONGODB_STORAGE_ENGINE_NAME === $storageNode['engine']) {
                $doctrineMongoDBODMDefinition = $container->getDefinition('doctrine_mongodb.odm.default_document_manager');
                $mongoDBStorageDefinition = $container->getDefinition('tchoulom.viewcounter.mongodb_storage');
                $mongoDBStorageDefinition->replaceArgument(0, $doctrineMongoDBODMDefinition);
            }
        }

        if (isset($geolocationNode['geolocator_id'])) {
            $geolocatorAdapterDefinition = $container->getDefinition('tchoulom.viewcounter.geolocator_adapter');
            $geolocatorDefinition = $container->getDefinition($geolocationNode['geolocator_id']);
            $geolocatorAdapterDefinition->replaceArgument(0, $geolocatorDefinition);
        }
    }

    /**
     * Gets the storage engine definition.
     *
     * @param ContainerBuilder $container The container.
     * @param string $storageEngine The storage engine.
     *
     * @return Definition
     */
    public function getStorageEngineDefinition(ContainerBuilder $container, string $storageEngine): Definition
    {
        if (in_array($storageEngine, ['filesystem', 'mongodb'])) {
            return $container->getDefinition('tchoulom.viewcounter.' . $storageEngine . '_storage');
        }

        return $container->getDefinition($storageEngine);
    }
}
