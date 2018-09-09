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
class Persister extends AbstractPersister
{
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