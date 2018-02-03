<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * This source file is subject to the MIT license.
 */

namespace Tchoulom\ViewCounterBundle\Model;

/**
 * Interface ViewCountable
 */
interface ViewCountable
{
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