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

#[MongoDB\Document(collection: 'pageContinent', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\PageContinentRepository')]
#[MongoDB\HasLifecycleCallbacks]
class PageContinent
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\ReferenceOne(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Page', name: 'page_id', inversedBy: 'pageContinents', nullable: false)]
    protected $page;

    #[MongoDB\ReferenceOne(targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Continent', name: 'continent_id', inversedBy: 'pageContinents', nullable: false)]
    protected $continent;

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
     * Gets the continent.
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
