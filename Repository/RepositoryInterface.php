<?php

namespace Tchoulom\ViewCounterBundle\Repository;


/**
 * Class AbstractRepository.
 */
interface RepositoryInterface
{
    /**
     * Saves the object.
     *
     * @param $object
     *
     * @return mixed
     */
    public function save($object);

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
    public function findOneBy(array $criteria, $orderBy = null, $limit = null, $offset = null);

    /**
     * Gets the EntityManager.
     *
     * @return mixed
     */
    public function getEntityManager();

    /**
     * Loads the Metadata.
     *
     * @param $object
     *
     * @return $this
     */
    public function loadMetadata($object);

    /**
     * Gets the Metadata.
     *
     * @return mixed
     */
    public function getMetadata();

    /**
     * Gets Mappings.
     *
     * @return mixed
     */
    public function getMappings();

    /**
     * Gets the property.
     *
     * @return mixed
     */
    public function getProperty();

    /**
     * Gets the class.
     *
     * @return mixed
     */
    public function getClass();

    /**
     * Gets the class Repository.
     *
     * @return mixed
     */
    public function getClassRepository();

    /**
     * Loads the ViewCounter Class.
     *
     * @return string|null The viewcounter class
     */
    public function loadViewCounterClass(): ?string;

    /**
     * Loads the entity identifier.
     *
     * @param string $entityName The entity name
     *
     * @return string|null The entity identifier
     */
    public function loadEntityIdentifier(string $entityName): ?string;
}