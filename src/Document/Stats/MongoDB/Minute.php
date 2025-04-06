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

namespace Tchoulom\ViewCounterBundle\Document\Stats\MongoDB;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'minute', repositoryClass: \Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\MinuteRepository::class)]
#[MongoDB\HasLifecycleCallbacks]
class Minute
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    protected $name;

    #[MongoDB\ReferenceOne(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Hour::class, name: 'hour_id', inversedBy: 'minutes')]
    protected $hour;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Second::class, mappedBy: 'minute', cascade: ['persist', 'remove'])]
    protected $seconds;

    /**
     * Minute constructor.
     */
    public function __construct()
    {
        $this->seconds = new ArrayCollection();
    }

    /**
     * Gets Id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets Name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets Hour.
     *
     * @return Hour
     */
    public function getHour(): Hour
    {
        return $this->hour;
    }

    /**
     * Sets Hour.
     *
     * @param Hour $hour
     *
     * @return self
     */
    public function setHour(Hour $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Gets Seconds.
     *
     * @return Collection|Second[]
     */
    public function getSeconds(): Collection
    {
        return $this->seconds;
    }

    /**
     * Add Second.
     *
     * @param Second $second
     *
     * @return self
     */
    public function addSecond(Second $second): self
    {
        if (!$this->seconds->contains($second)) {
            $this->seconds[] = $second;
            $second->setMinute($this);
        }

        return $this;
    }

    /**
     * Remove Second.
     *
     * @param Second $second
     *
     * @return self
     */
    public function removeSecond(Second $second): self
    {
        if ($this->seconds->contains($second)) {
            $this->seconds->removeElement($second);
        }

        return $this;
    }
}
