<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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

        $viewcounterNode = $this->getViewCounterNode($configs);
        $statsNode = $this->getStatsNode($configs);
        $storageNode = $this->getStorageNode($configs);
        $geolocationNode = $this->getGeolocationNode($configs);

        $viewcounterNodeDefinition = $container->getDefinition('tchoulom.viewcounter_node_config');
        $statisticsNodeDefinition = $container->getDefinition('tchoulom.statistics_node_config');

        $viewcounterNodeDefinition->replaceArgument(0, $viewcounterNode);
        $statisticsNodeDefinition->replaceArgument(0, $statsNode);

        if (isset($geolocationNode['geolocator_id'])) {
            $geolocatorAdapterDefinition = $container->getDefinition('tchoulom.viewcounter.geolocator_adapter');
            $geolocatorDefinition = $container->getDefinition($geolocationNode['geolocator_id']);
            $geolocatorAdapterDefinition->replaceArgument(0, $geolocatorDefinition);
        }

        if (isset($storageNode['service'])) {
            $storageAdapterDefinition = $container->getDefinition('tchoulom.viewcounter.storage_adapter');
            $storerDefinition = $container->getDefinition($storageNode['service']);
            $storageAdapterDefinition->replaceArgument(0, $storerDefinition);
        }
    }

    /**
     * Gets the view counter node configuration
     *
     * @param array $configs
     *
     * @return array
     */
    public function getViewCounterNode(array $configs): array
    {
        return $configs[0]['view_counter'];
    }

    /**
     * Gets the stats node configuration
     *
     * @param array $configs
     *
     * @return array
     */
    public function getStatsNode(array $configs): array
    {
        return $configs[0]['statistics'];
    }

    /**
     * Gets the storage node configuration
     *
     * @param array $configs
     *
     * @return array
     */
    public function getStorageNode(array $configs): array
    {
        return $configs[0]['storage'];
    }

    /**
     * Gets the geolocation node.
     *
     * @param array $configs
     *
     * @return array|null
     */
    public function getGeolocationNode(array $configs): ?array
    {
        $configs = $configs[0];
        if (isset($configs['geolocation'])) {
            return $configs['geolocation'];
        }

        return null;
    }
}
