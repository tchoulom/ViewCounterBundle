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

namespace Tchoulom\ViewCounterBundle\Adapter\Storage;

/**
 * Class StorageAdapter
 */
class StorageAdapter implements StorageAdapterInterface
{
    /**
     * @var StorageAdapterInterface The storage service.
     */
    protected $storer;

    /**
     * StorageAdapter constructor.
     *
     * @param StorageAdapterInterface $storer The storage service.
     */
    public function __construct(StorageAdapterInterface $storer)
    {
        $this->storer = $storer;
    }

    /**
     * Saves the statistics.
     *
     * @param $stats
     */
    public function save($stats)
    {
        $this->storer->save($stats);
    }

    /**
     * Loads the contents.
     *
     * @return mixed
     */
    public function loadContents()
    {
        return $this->storer->loadContents();
    }
}
