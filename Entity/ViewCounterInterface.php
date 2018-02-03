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

namespace Tchoulom\ViewCounterBundle\Entity;


/**
 * ViewCounter
 *
 * @MappedSuperclass
 *
 * @ORM\HasLifecycleCallbacks
 */
interface ViewCounterInterface
{
    /**
     * Get the ID
     *
     * @return integer
     */
    public function getId();

    /**
     * Get the IP
     *
     * @return text
     */
    public function getIp();

    /**
     * Set viewDate
     *
     * @param $ip
     *
     * @return $this
     */
    public function setIp($ip);

    /**
     * Get viewDate
     *
     * @return \DateTime
     */
    public function getViewDate();

    /**
     * Set viewDate
     *
     * @param \DateTime $viewDate
     *
     * @return $this
     */
    public function setViewDate($viewDate);
}