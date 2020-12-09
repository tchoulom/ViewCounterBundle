<?php

namespace Tchoulom\ViewCounterBundle\Entity;


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
     * Gets the ViewCountable entity.
     *
     * @return ViewCountable The ViewCountable entity.
     */
    public function getPage(): ViewCountable;

    /**
     * Sets the ViewCountable entity.
     *
     * @param ViewCountable $page The ViewCountable entity.
     *
     * @return self
     */
    public function setPage(ViewCountable $page): self;

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
     * @return $this
     */
    public function setIp($ip);

    /**
     * Gets viewDate
     *
     * @return \DateTime
     */
    public function getViewDate();

    /**
     * Sets viewDate
     *
     * @param \DateTime $viewDate
     *
     * @return $this
     */
    public function setViewDate($viewDate);
}