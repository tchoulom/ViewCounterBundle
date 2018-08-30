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

namespace Tchoulom\ViewCounterBundle\Persister;


/**
 * Class Persister
 */
interface PersisterInterface
{
    /**
     * Saves the object.
     *
     * @param $object
     */
    public function save($object);

    /**
     * Gets the EntityManager.
     *
     * @return EntityManagerInterface
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
     * Finds One By.
     *
     * @param $class
     * @param $criteria
     * @param null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return null|object
     */
    public function findOneBy($class, $criteria, $orderBy = null, $limit = null, $offset = null);
}