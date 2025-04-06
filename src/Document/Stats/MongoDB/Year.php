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

#[MongoDB\Document(collection: 'year', repositoryClass: \Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\YearRepository::class)]
#[MongoDB\HasLifecycleCallbacks]
class Year
{
    use NumberTrait;
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\ReferenceOne(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Page::class, name: 'page_id', inversedBy: 'years')]
    protected $page;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Month::class, mappedBy: 'year', cascade: ['persist', 'remove'])]
    protected $months;

    /**
     * Year constructor.
     */
    public function __construct()
    {
        $this->months = new ArrayCollection();
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
     * Gets Page.
     *
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * Sets Page.
     *
     * @param Page $page
     *
     * @return self
     */
    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets Months.
     *
     * @return Collection|Month[]
     */
    public function getMonths(): Collection
    {
        return $this->months;
    }

    /**
     * Add Month.
     *
     * @param Month $month
     *
     * @return self
     */
    public function addMonth(Month $month): self
    {
        if (!$this->months->contains($month)) {
            $this->months[] = $month;
            $month->setYear($this);
        }

        return $this;
    }

    /**
     * Remove Month.
     *
     * @param Month $month
     *
     * @return self
     */
    public function removeMonth(Month $month): self
    {
        if ($this->months->contains($month)) {
            $this->months->removeElement($month);
        }

        return $this;
    }
}
