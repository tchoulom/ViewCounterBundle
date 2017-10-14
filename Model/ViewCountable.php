<?php

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