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

namespace Tchoulom\ViewCounterBundle\ETL;

use Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;

/**
 * Class StatsConverter
 *
 * Converts ViewCounter entities to statistical data.
 */
class StatsConverter
{
    /**
     * The StorageAdapter service.
     *
     * @var StorageAdapterInterface
     */
    protected $storageAdapter;

    /**
     * StatsConverter constructor.
     *
     * @param StorageAdapterInterface $storageAdapter
     */
    public function __construct(StorageAdapterInterface $storageAdapter)
    {
        $this->storageAdapter = $storageAdapter;
    }

    /**
     * Converts ViewCounter entities to statistical data.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity to be converted into statistical data.
     *
     * @throws \ReflectionException
     */
    public function convert(ViewCounterInterface $viewcounter)
    {
        $this->storageAdapter->save($viewcounter);
    }
}
