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

#[MongoDB\Document(collection: 'country', repositoryClass: \Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\CountryRepository::class)]
#[MongoDB\HasLifecycleCallbacks]
class Country
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    protected $name;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageCountry::class, mappedBy: 'country')]
    protected $pageCountries;

    #[MongoDB\ReferenceOne(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Continent::class, name: 'continent_id', inversedBy: 'countries')]
    protected $continent;

    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->pageCountries = new ArrayCollection();
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
     * Gets pageCountries.
     *
     * @return Collection|PageCountry[]
     */
    public function getPageCountries(): Collection
    {
        return $this->pageCountries;
    }

    /**
     * Add Page.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function addPageCountry(Page $page): self
    {
        if (!$this->pageCountries->contains($page)) {
            $this->pageCountries[] = $page;
            // not needed for persistence, just keeping both sides in sync
            // $page->addPageCountry($this);
        }

        return $this;
    }

    /**
     * Remove Page.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function removePageCountry(Page $page): self
    {
        if ($this->pageCountries->contains($page)) {
            $this->pageCountries->removeElement($page);
            // not needed for persistence, just keeping both sides in sync
            // $page->removePageCountry($this);
        }

        return $this;
    }

    /**
     * Gets Continent.
     *
     * @return Continent The continent.
     */
    public function getContinent(): Continent
    {
        return $this->continent;
    }

    /**
     * Sets the continent.
     *
     * @param Continent $continent The continent.
     *
     * @return self
     */
    public function setContinent(Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }
}
