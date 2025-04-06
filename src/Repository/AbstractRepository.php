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

namespace Tchoulom\ViewCounterBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Tchoulom\ViewCounterBundle\Entity\ViewCounter as BaseViewCounter;

/**
 * Class AbstractRepository.
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * The EntityManager
     *
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * The metadata.
     */
    protected $metadata;

    /**
     * AbstractPersister constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
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
        $this->metadata = $this->getEntityManager()->getClassMetadata($object::class);

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

    /**
     * Loads the ViewCounter Class.
     *
     * @return string|null The viewcounter class
     */
    public function loadViewCounterClass(): ?string
    {
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($metadatas as $metadata) {
            if ($metadata->getReflectionClass()->getParentClass() instanceof \ReflectionClass
                && BaseViewCounter::class === $metadata->getReflectionClass()->getParentClass()->getName()
            ) {
                return $metadata->getReflectionClass()->getName();
            }
        }

        return null;
    }

    /**
     * Loads the entity identifier.
     *
     * @param string $entityName The entity name
     *
     * @return string|null The entity identifier
     */
    public function loadEntityIdentifier(string $entityName): ?string
    {
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        foreach ($metadatas as $metadata) {
            if ($metadata->getName() === $metadata->namespace . '\\' . ucfirst($entityName)) {
                if (isset($metadata->getIdentifier()[0])) {
                    return $metadata->getIdentifier()[0];
                }
            }
        }

        return null;
    }
}