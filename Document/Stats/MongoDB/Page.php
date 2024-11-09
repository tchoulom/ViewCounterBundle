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
use DateTimeInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: 'page', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\PageRepository')]
#[MongoDB\HasLifecycleCallbacks]
class Page
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'integer', name: 'page_ref')]
    protected $pageRef;

    #[MongoDB\Field(type: 'string', name: 'class_ref')]
    protected $classRef;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Year', mappedBy: 'page', cascade: ['persist', 'remove'])]
    protected $years;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageCountry', mappedBy: 'page')]
    protected $pageCountries;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageContinent', mappedBy: 'page')]
    protected $pageContinents;

    #[MongoDB\Field(type: 'date', name: 'view_date')]
    protected $viewDate;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->years = new ArrayCollection();
        $this->pageCountries = new ArrayCollection();
        $this->pageContinents = new ArrayCollection();
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
     * Gets the view date.
     *
     * @return DateTimeInterface
     */
    public function getViewDate(): DateTimeInterface
    {
        return $this->viewDate;
    }

    /**
     * Sets the view date.
     *
     * @param DateTimeInterface $viewDate
     *
     * @return self
     */
    public function setViewDate(DateTimeInterface $viewDate): self
    {
        $this->viewDate = $viewDate;

        return $this;
    }

    /**
     * Gets Page Ref.
     *
     * @return int
     */
    public function getPageRef(): int
    {
        return $this->pageRef;
    }

    /**
     * Sets Page Ref.
     *
     * @param int $pageRef
     *
     * @return self
     */
    public function setPageRef(int $pageRef): self
    {
        $this->pageRef = $pageRef;

        return $this;
    }

    /**
     * Gets ClassRef.
     *
     * @return string
     */
    public function getClassRef(): string
    {
        return $this->classRef;
    }

    /**
     * Sets ClassRef.
     *
     * @param string $classRef
     *
     * @return self
     */
    public function setClassRef(string $classRef): self
    {
        $this->classRef = $classRef;

        return $this;
    }

    /**
     * Gets Years.
     *
     * @return Collection|Year[]
     */
    public function getYears(): Collection
    {
        return $this->years;
    }

    /**
     * Add Year.
     *
     * @param Year $year
     *
     * @return self
     */
    public function addYear(Year $year): self
    {
        if (!$this->years->contains($year)) {
            $this->years[] = $year;
            $year->setPage($this);
        }

        return $this;
    }

    /**
     * Remove Year.
     *
     * @param Year $year
     *
     * @return self
     */
    public function removeYear(Year $year): self
    {
        if ($this->years->contains($year)) {
            $this->years->removeElement($year);
        }

        return $this;
    }

    /**
     * Gets pageCountries.
     *
     * @return Collection|PageCountry[]
     */
    public function getPageCountries(): Collection
    {
        return $this->pageCountries;
    }

    /**
     * Add Country.
     *
     * @param Country $country The country.
     *
     * @return self
     */
    public function addPageCountry(Country $country): self
    {
        if (!$this->pageCountries->contains($country)) {
            $this->pageCountries[] = $country;
            // not needed for persistence, just keeping both sides in sync
            $country->addPageCountry($this);
        }

        return $this;
    }

    /**
     * Remove Country.
     *
     * @param Country $country The country.
     *
     * @return self
     */
    public function removePageCountry(Country $country): self
    {
        if ($this->pageCountries->contains($country)) {
            $this->pageCountries->removeElement($country);
            // not needed for persistence, just keeping both sides in sync
            $country->removePageCountry($this);
        }

        return $this;
    }

    /**
     * Gets PageContinents.
     *
     * @return Collection|PageContinent[]
     */
    public function getPageContinents(): Collection
    {
        return $this->pageContinents;
    }

    /**
     * Add Continent.
     *
     * @param Continent $continent
     *
     * @return self
     */
    public function addPageContinent(Continent $continent): self
    {
        if (!$this->pageContinents->contains($continent)) {
            $this->pageContinents[] = $continent;
            // not needed for persistence, just keeping both sides in sync
            $continent->addPageContinent($this);
        }

        return $this;
    }

    /**
     * Remove Continent.
     *
     * @param Continent $continent
     *
     * @return self
     */
    public function removePageContinent(Continent $continent): self
    {
        if ($this->pageContinents->contains($continent)) {
            $this->pageContinents->removeElement($continent);
            // not needed for persistence, just keeping both sides in sync
            $continent->removePageContinent($this);
        }

        return $this;
    }
}
