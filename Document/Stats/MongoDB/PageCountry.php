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

#[MongoDB\Document(collection: 'PageCountry', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\PageCountryRepository')]
#[MongoDB\HasLifecycleCallbacks]
class PageCountry
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\ReferenceOne(name: 'page_id', nullable: false, targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Page', inversedBy: 'pageCountries')]
    protected $page;

    #[MongoDB\ReferenceOne(name: 'country_id', nullable: false, targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Country', inversedBy: 'pageCountries')]
    protected $country;

    #[MongoDb\ReferenceMany(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Region', cascade: ['persist', 'remove'], mappedBy: 'country')]
    protected $regions;

    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * Gets the page.
     *
     * @return Page The page.
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * Sets the page.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets the country.
     *
     * @return Country The country.
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Sets the country.
     *
     * @param Country $country The country.
     *
     * @return self
     */
    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Gets Regions.
     *
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    /**
     * Add Region.
     *
     * @param Region $region
     *
     * @return self
     */
    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setCountry($this);
        }

        return $this;
    }

    /**
     * Remove Region.
     *
     * @param Region $region
     *
     * @return self
     */
    public function removeRegion(Region $region): self
    {
        if ($this->regions->contains($region)) {
            $this->regions->removeElement($region);
        }

        return $this;
    }
}
