<?php

namespace Tchoulom\ViewCounterBundle\Entity;

use DateTimeInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * ViewCounterInterface
 */
interface ViewCounterInterface
{
    /**
     * Gets the ID
     *
     * @return integer
     */
    public function getId();

    /**
     * Gets the IP
     *
     * @return text
     */
    public function getIp();

    /**
     * Sets viewDate
     *
     * @param $ip
     *
     * @return self
     */
    public function setIp($ip);

    /**
     * Gets viewDate
     *
     * @return DateTimeInterface
     */
    public function getViewDate();

    /**
     * Sets viewDate
     *
     * @param DateTimeInterface $viewDate
     *
     * @return self
     */
    public function setViewDate(DateTimeInterface $viewDate);
}