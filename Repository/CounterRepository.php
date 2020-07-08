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

use Tchoulom\ViewCounterBundle\Exception\RuntimeException;

/**
 * Class CounterRepository
 */
class CounterRepository extends AbstractRepository
{
    protected const VIEWCOUNTER_CLASS_NOT_FOUND_MSG = 'ViewCounter class not found!';

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

    /**
     * Cleanup the viewcounter data.
     *
     * @param \DateTimeInterface|null $min
     * @param \DateTimeInterface|null $max
     *
     * @return int The number of rows deleted.
     */
    public function cleanup(\DateTimeInterface $min = null, \DateTimeInterface $max = null): int
    {
        $where = false;
        $viewcounterClass = $this->loadViewCounterClass();

        if (null == $viewcounterClass) {
            throw new RuntimeException(self::VIEWCOUNTER_CLASS_NOT_FOUND_MSG);
        }

        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder->delete($viewcounterClass, 'v');

        if ($min instanceof \DateTimeInterface) {
            $andWhere = true === $where ? 'andWhere' : 'where';
            $where = true;
            $queryBuilder->$andWhere('v.viewDate >= :min')
                ->setParameter('min', $min);
        }
        if ($max instanceof \DateTimeInterface) {
            $andWhere = true === $where ? 'andWhere' : 'where';
            $queryBuilder->$andWhere('v.viewDate <= :max')
                ->setParameter('max', $max);
        }

        return $queryBuilder->getQuery()->execute();
    }
}