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

namespace Tchoulom\ViewCounterBundle\Tests\Entity;

use Tchoulom\ViewCounterBundle\Entity\ViewCounter;
use Tchoulom\ViewCounterBundle\Tests\BaseTest;

/**
 * Class ViewCounterTest
 */
class ViewCounterTest extends BaseTest
{
    /**
     * Setup the fixtures.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * tests GetIp
     */
    public function testGetIp()
    {
        $thisEntity = $this->viewCounterEntity->setIp($this->clientIP);

        $this->assertInstanceOf(ViewCounter::class, $thisEntity);
        $this->assertTrue(is_string($this->viewCounterEntity->getIp()));
    }

    /**
     * tests ViewDate
     */
    public function testViewDate()
    {
        $entityViewed = $this->viewCounterEntity->setViewDate($this->viewDate);

        $this->assertInstanceOf(ViewCounter::class, $entityViewed);
        $this->assertTrue(is_numeric($this->viewCounterEntity->getViewDate()->getTimestamp()));
    }
}