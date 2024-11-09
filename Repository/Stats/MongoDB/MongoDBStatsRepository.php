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

namespace Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Tchoulom\ViewCounterBundle\Repository\DocumentRepositoryInterface;

/**
 * Class MongoDBStatsRepository
 *
 * @package Tchoulom\ViewCounterBundle\Repository\Stats\MongoDB
 */
class MongoDBStatsRepository extends DocumentRepository implements DocumentRepositoryInterface
{
}
