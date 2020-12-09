<?php

namespace Tchoulom\ViewCounterBundle\Adapter\Storage;


/**
 * Class StorageAdapter
 */
interface StorageAdapterInterface
{
    /**
     * Saves the statistics.
     *
     * @param $stats
     */
    public function save($stats);

    /**
     * Loads the contents.
     *
     * @return mixed
     */
    public function loadContents();
}
