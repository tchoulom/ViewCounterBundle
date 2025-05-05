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

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Types\Type;

#[MongoDB\Document(collection: 'city', repositoryClass: 'Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB\CityRepository')]
#[MongoDB\HasLifecycleCallbacks]
class City
{
    use ViewTrait;
    use AuditTrait;

    #[MongoDB\Id]
    private $id;

    #[MongoDB\Field(type: Type::STRING)]
    protected $name;

    #[MongoDB\ReferenceOne(name: 'region_id', targetDocument: 'Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Region', inversedBy: 'cities')]
    protected $region;

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
     * Gets Region.
     *
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * Sets Region.
     *
     * @param Region $region
     *
     * @return self
     */
    public function setRegion(Region $region): self
    {
        $this->region = $region;

        return $this;
    }
}
