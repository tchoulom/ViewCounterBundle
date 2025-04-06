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


use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * Interface StorageAdapterInterface
 *
 * @package Tchoulom\ViewCounterBundle\Adapter\Storage
 */
interface StorageAdapterInterface
{
    /**
     * Saves the statistics.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     */
    public function save(ViewCounterInterface $viewcounter);
}
