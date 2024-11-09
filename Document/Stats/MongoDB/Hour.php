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

#[MongoDB\Document(collection: 'hour', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\HourRepository')]
#[MongoDB\HasLifecycleCallbacks]
class Hour
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    protected $name;

    #[MongoDB\ReferenceOne(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Day', name: 'day_id', inversedBy: 'hours')]
    protected $day;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Minute', mappedBy: 'hour', cascade: ['persist', 'remove'])]
    protected $minutes;

    /**
     * Hour constructor.
     */
    public function __construct()
    {
        $this->minutes = new ArrayCollection();
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
     * Gets Day.
     *
     * @return Day
     */
    public function getDay(): Day
    {
        return $this->day;
    }

    /**
     * Sets Day.
     *
     * @param Day $day
     *
     * @return self
     */
    public function setDay(Day $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Gets Minutes.
     *
     * @return Collection|Minute[]
     */
    public function getMinutes(): Collection
    {
        return $this->minutes;
    }

    /**
     * Add Minute.
     *
     * @param Minute $minute
     *
     * @return self
     */
    public function addMinute(Minute $minute): self
    {
        if (!$this->minutes->contains($minute)) {
            $this->minutes[] = $minute;
            $minute->setHour($this);
        }

        return $this;
    }

    /**
     * Remove Minute.
     *
     * @param Minute $minute
     *
     * @return self
     */
    public function removeMinute(Minute $minute): self
    {
        if ($this->minutes->contains($minute)) {
            $this->minutes->removeElement($minute);
        }

        return $this;
    }
}
