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

#[MongoDB\Document(collection: 'region', repositoryClass: \Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\RegionRepository::class)]
#[MongoDB\HasLifecycleCallbacks]
class Region
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    protected $name;

    #[MongoDB\ReferenceOne(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageCountry::class, name: 'page_country_id', inversedBy: 'regions')]
    protected $pageCountry;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\City::class, mappedBy: 'region', cascade: ['persist', 'remove'])]
    protected $cities;

    /**
     * Region constructor.
     */
    public function __construct()
    {
        $this->cities = new ArrayCollection();
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
     * Gets PageCountry.
     *
     * @return PageCountry
     */
    public function getPageCountry(): PageCountry
    {
        return $this->pageCountry;
    }

    /**
     * Sets PageCountry.
     *
     * @param PageCountry $pageCountry
     *
     * @return self
     */
    public function setPageCountry(PageCountry $pageCountry): self
    {
        $this->pageCountry = $pageCountry;

        return $this;
    }

    /**
     * Gets Cities.
     *
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    /**
     * Add City.
     *
     * @param City $city
     *
     * @return self
     */
    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setRegion($this);
        }

        return $this;
    }

    /**
     * Remove City.
     *
     * @param City $city
     *
     * @return self
     */
    public function removeCity(City $city): self
    {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
        }

        return $this;
    }
}
