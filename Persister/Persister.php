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

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Persister
 */
class Persister implements PersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * ViewCounter constructor.
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
     */
    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    /**
     * Gets the EntityManager.
     *
     * @return EntityManagerInterface
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
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function loadMetadata($object)
    {
        $metadata = $this->getEntityManager()->getClassMetadata(get_class($object));

        return $metadata;
    }

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
    public function findOneBy($class, $criteria, $orderBy = null, $limit = null, $offset = null)
    {
        $result = $this->getEntityManager()->getRepository($class)->findOneBy($criteria, $orderBy, $limit, $offset);

        return $result;
    }
}