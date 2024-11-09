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

#[MongoDB\Document(collection: 'week', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\WeekRepository')]
#[MongoDB\HasLifecycleCallbacks]
class Week
{
    use NumberTrait;
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\ReferenceOne(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Month', name: 'month_id', inversedBy: 'weeks')]
    protected $month;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Day', mappedBy: 'week', cascade: ['persist', 'remove'])]
    protected $days;

    /**
     * Week constructor.
     */
    public function __construct()
    {
        $this->days = new ArrayCollection();
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
     * Gets Month.
     *
     * @return Month
     */
    public function getMonth(): Month
    {
        return $this->month;
    }

    /**
     * Sets Month.
     *
     * @param Month $month
     *
     * @return self
     */
    public function setMonth(Month $month): self
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Gets Days.
     *
     * @return Collection|Day[]
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    /**
     * Add Day.
     *
     * @param Day $day
     *
     * @return self
     */
    public function addDay(Day $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days[] = $day;
            $day->setWeek($this);
        }

        return $this;
    }

    /**
     * Remove Day.
     *
     * @param Day $day
     *
     * @return self
     */
    public function removeDay(Day $day): self
    {
        if ($this->days->contains($day)) {
            $this->days->removeElement($day);
        }

        return $this;
    }
}
