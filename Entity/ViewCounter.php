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

namespace Tchoulom\ViewCounterBundle\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * ViewCounter Entity
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class ViewCounter implements ViewCounterInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var text $ip
     *
     * @ORM\Column(name="ip", type="text", nullable=false)
     */
    #[ORM\Column(name: 'ip', type: 'text', nullable: false)]
    protected $ip;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="view_date", type="datetime", nullable=false)
     */
    #[ORM\Column(name: 'view_date', type: 'datetime', nullable: false)]
    protected $viewDate;

    /**
     * The property name.
     *
     * @var string
     */
    protected $property;

    /**
     * Gets the ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the IP
     *
     * @return text
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Sets viewDate
     *
     * @param $ip
     *
     * @return self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Gets viewDate
     *
     * @return DateTimeInterface
     */
    public function getViewDate()
    {
        return $this->viewDate;
    }

    /**
     * Sets viewDate
     *
     * @param DateTimeInterface $viewDate
     *
     * @return self
     */
    public function setViewDate(DateTimeInterface $viewDate)
    {
        $this->viewDate = $viewDate;

        return $this;
    }

    /**
     * Sets the property name.
     *
     * @param string $property
     *
     * @return self
     */
    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Gets the property name.
     *
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * Sets the page.
     *
     * @param ViewCountable $page
     * @param string $property
     *
     * @return self
     */
    public function setPage(ViewCountable $page): self
    {
        $property = $this->getProperty();
        $setPage = 'set' . ucfirst($property);
        $this->$setPage($page);

        return $this;
    }

    /**
     * Gets the page.
     *
     * @return ViewCountable|null
     */
    public function getPage(): ?ViewCountable
    {
        $property = $this->getProperty();
        $getPage = 'get' . ucfirst($property);
        $page = $this->$getPage();

        return $page;
    }
}
