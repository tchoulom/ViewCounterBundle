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
 * Class RepositoryInterface.
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
     * @return \Doctrine\ORM\Mapping\ClassMetadata
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
}