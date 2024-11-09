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

#[MongoDB\Document(collection: 'month', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\MonthRepository')]
#[MongoDB\HasLifecycleCallbacks]
class Month
{
    use NumberTrait;
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\ReferenceOne(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Year', name: 'year_id', inversedBy: 'months')]
    protected $year;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Week', mappedBy: 'month', cascade: ['persist', 'remove'])]
    protected $weeks;

    /**
     * Month constructor.
     */
    public function __construct()
    {
        $this->weeks = new ArrayCollection();
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
     * Gets Year.
     *
     * @return Year
     */
    public function getYear(): Year
    {
        return $this->year;
    }

    /**
     * Sets Year.
     *
     * @param Year $year
     *
     * @return self
     */
    public function setYear(Year $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Gets Weeks.
     *
     * @return Collection|Week[]
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    /**
     * Add Week.
     *
     * @param Week $week
     *
     * @return self
     */
    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks[] = $week;
            $week->setMonth($this);
        }

        return $this;
    }

    /**
     * Remove Week.
     *
     * @param Week $week
     *
     * @return self
     */
    public function removeWeek(Week $week): self
    {
        if ($this->weeks->contains($week)) {
            $this->weeks->removeElement($week);
        }

        return $this;
    }
}
