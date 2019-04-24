<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\Repository;

/**
 * Class AbstractRepository.
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * The EntityManager
     */
    protected $em;

    /**
     * The metadata.
     */
    protected $metadata;

    /**
     * AbstractPersister constructor.
     *
     * @param $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Saves the object.
     *
     * @param $object
     *
     * @return mixed
     */
    abstract public function save($object);

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
    abstract public function findOneBy(array $criteria, $orderBy = null, $limit = null, $offset = null);

    /**
     * Gets the EntityManager.
     *
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Loads the Metadata.
     *
     * @param $object
     *
     * @return $this
     */
    public function loadMetadata($object)
    {
        $this->metadata = $this->getEntityManager()->getClassMetadata(get_class($object));

        return $this;
    }

    /**
     * Gets the Metadata.
     *
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Gets Mappings.
     *
     * @return mixed
     */
    public function getMappings()
    {
        return $this->getMetadata()->getAssociationMappings();
    }

    /**
     * Gets the property.
     *
     * @return mixed
     */
    public function getProperty()
    {
        return $this->getMappings()['viewCounters']['mappedBy'];
    }

    /**
     * Gets the class.
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->getMappings()['viewCounters']['targetEntity'];
    }

    /**
     * Gets the class Repository.
     *
     * @return mixed
     */
    public function getClassRepository()
    {
        $class = $this->getClass();

        return $this->getEntityManager()->getRepository($class);
    }
}