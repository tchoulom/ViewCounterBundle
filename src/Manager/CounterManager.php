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

namespace Tchoulom\ViewCounterBundle\Manager;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Repository\RepositoryInterface;


/**
 * Class CounterManager
 */
class CounterManager
{
    /**
     * @var RepositoryInterface
     */
    protected $counterRepository;

    /**
     * @var RepositoryInterface
     */
    protected $metadata;

    /**
     * CounterManager constructor.
     * @param RepositoryInterface $counterRepository
     */
    public function __construct(RepositoryInterface $counterRepository)
    {
        $this->counterRepository = $counterRepository;
    }

    /**
     * Saves the object.
     *
     * @param $object
     */
    public function save($object)
    {
        $this->counterRepository->save($object);
    }

    /**
     * Finds One By.
     *
     * @param array $criteria
     * @param null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return mixed
     */
    public function findOneBy(array $criteria, $orderBy = null, $limit = null, $offset = null)
    {
        $result = $this->counterRepository->findOneBy($criteria, $orderBy, $limit, $offset);

        return $result;
    }

    /**
     * Loads Metadata.
     *
     * @param $object
     *
     * @return $this
     */
    public function loadMetadata($object)
    {
        $this->metadata = $this->counterRepository->loadMetadata($object);

        return $this;
    }

    /**
     * Gets the property.
     *
     * @return mixed
     */
    public function getProperty()
    {
        return $this->counterRepository->getProperty();
    }

    public function getMappings()
    {
        return $this->counterRepository->getMappings();
    }

    /**
     * Gets the Class.
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->counterRepository->getClass();
    }

    /**
     * Cleanup the viewcounter data.
     *
     * @param \DateTimeInterface|null $min The min view date
     * @param \DateTimeInterface|null $max the max view date
     *
     * @return int The number of rows deleted.
     */
    public function cleanup(?\DateTimeInterface $min = null, ?\DateTimeInterface $max = null): int
    {
        return $this->counterRepository->cleanup($min, $max);
    }

    /**
     * Loads the ViewCounter data.
     *
     * @return ViewCounterInterface[]
     */
    public function loadViewCounterData()
    {
        return $this->counterRepository->loadViewCounterData();
    }

    /**
     * Sets the property.
     *
     * @param ViewCounterInterface $viewcounter
     *
     * @return ViewCounterInterface
     */
    public function setProperty(ViewCounterInterface $viewcounter): ViewCounterInterface
    {
        $this->loadMetadata($viewcounter);

        foreach ($this->getMappings() as $mapping) {
            $property = $mapping['fieldName'];
            $viewcounter->setProperty($property);
            if ($viewcounter->getPage() !== null) {
                $viewcounter->setProperty($property);
                break;
            }
        }

        return $viewcounter;
    }
}
