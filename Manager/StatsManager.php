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

namespace Tchoulom\ViewCounterBundle\Manager;

use Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use \ReflectionException;

/**
 * Class StatsManager is used to manage statistics.
 */
class StatsManager
{
    /**
     * The StorageAdapter service.
     *
     * @var StorageAdapterInterface
     */
    protected $storageAdapter;

    /**
     * Statistics constructor.
     *
     * @param StorageAdapterInterface $storageAdapter
     */
    public function __construct(StorageAdapterInterface $storageAdapter)
    {
        $this->storageAdapter = $storageAdapter;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @throws ReflectionException
     */
    public function register(ViewCounterInterface $viewcounter): void
    {
        $this->storageAdapter->save($viewcounter);
    }
}
