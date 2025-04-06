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

namespace Tchoulom\ViewCounterBundle\Model;

/**
 * Interface ViewCountable
 */
interface ViewCountable
{
    /**
     * Gets id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get $views
     *
     * @return integer
     */
    public function getViews();

    /**
     * Set $views
     *
     * @param integer $views
     *
     * @return $this
     */
    public function setViews($views);
}