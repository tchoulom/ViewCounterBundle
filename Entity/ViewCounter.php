<?php

namespace Tchoulom\ViewCounterBundle\Entity;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ViewCounter
 *
 * @MappedSuperclass
 *
 * @ORM\HasLifecycleCallbacks
 */
class ViewCounter implements ViewCounterInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var text $ip
     *
     * @ORM\Column(name="ip", type="text", nullable=false)
     */
    protected $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="view_date", type="datetime", nullable=false)
     */
    private $viewDate;

    /**
     * Get the ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the IP
     *
     * @return text
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set viewDate
     *
     * @param $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get viewDate
     *
     * @return \DateTime
     */
    public function getViewDate()
    {
        return $this->viewDate;
    }

    /**
     * Set viewDate
     *
     * @param \DateTime $viewDate
     *
     * @return $this
     */
    public function setViewDate($viewDate)
    {
        $this->viewDate = $viewDate;

        return $this;
    }
}
