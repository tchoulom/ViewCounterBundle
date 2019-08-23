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
 * Class CounterRepository
 */
class CounterRepository extends AbstractRepository
{
    /**
     * Saves the object.
     *
     * @param $object
     *
     * @return mixed
     * @throws \Exception
     */
    public function save($object)
    {
        try {
            $this->em->persist($object);
            $this->em->flush();
        } catch (\Exception $e) {
            throw $e;
        }

        return $object;
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
        $result = $this->getClassRepository()->findOneBy($criteria, $orderBy, $limit, $offset);

        return $result;
    }
}