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

#[MongoDB\Document(collection: 'continent', repositoryClass: \Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\ContinentRepository::class)]
#[MongoDB\HasLifecycleCallbacks]
class Continent
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: 'string')]
    protected $name;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageContinent::class, mappedBy: 'continent')]
    protected $pageContinents;

    #[MongoDb\ReferenceMany(targetDocument: \Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Country::class, mappedBy: 'continent', cascade: ['persist', 'remove'])]
    protected $countries;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->pageContinents = new ArrayCollection();
        $this->countries = new ArrayCollection();
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
     * Gets PageContinents.
     *
     * @return Collection|Country[]
     */
    public function getPageContinents(): Collection
    {
        return $this->pageContinents;
    }

    /**
     * Add Page.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function addPageContinent(Page $page): self
    {
        if (!$this->pageContinents->contains($page)) {
            $this->pageContinents[] = $page;
            // not needed for persistence, just keeping both sides in sync
            // $page->addPageContinent($this);
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
    public function removePageContinent(Page $page): self
    {
        if ($this->pageContinents->contains($page)) {
            $this->pageContinents->removeElement($page);
            // not needed for persistence, just keeping both sides in sync
            // $page->removePageContinent($this);
        }

        return $this;
    }

    /**
     * Gets Countries.
     *
     * @return Collection|Country[]
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    /**
     * Add Country.
     *
     * @param Country $country
     *
     * @return self
     */
    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
            $country->setContinent($this);
        }

        return $this;
    }

    /**
     * Remove Country.
     *
     * @param Country $country
     *
     * @return self
     */
    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
        }

        return $this;
    }
}
