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

namespace Tchoulom\ViewCounterBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tchoulom\ViewCounterBundle\DependencyInjection\Compiler\ViewcounterPass;

class TchoulomViewCounterBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ViewcounterPass());
    }

    /**
     * The supported view strategy.
     *
     * @var array
     */
    const SUPPORTED_STRATEGY = ['on_refresh', 'unique_view', 'daily_view', 'hourly_view', 'weekly_view', 'monthly_view', 'yearly_view', 'view_per_minute', 'view_per_second'];

    /**
     * The supported statistics keys.
     *
     * @var array
     */
    const SUPPORTED_STATS_KEYS = ['enabled', 'stats_file_name', 'stats_file_extension'];

    /**
     * The filesystem storage engine name.
     *
     * @var string
     */
    const FILESYSTEM_STORAGE_ENGINE_NAME = 'filesystem';

    /**
     * The mongodb storage engine name.
     *
     * @var string
     */
    const MONGODB_STORAGE_ENGINE_NAME = 'mongodb';
}
