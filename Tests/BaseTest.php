<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 * 
 * This source file is subject to the MIT license.
 */

namespace Tchoulom\ViewCounterBundle\Tests;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounter as ViewCounterEntity;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Service\ViewCounter;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{
    protected $defaultIP = '127.0.0.1';
    protected $viewDate = null;
    protected $viewCountableMock;
    protected $entityManagerMock;
    protected $requestStack;
    protected $viewInterval = ['daily_view', 'unique_view', 'hourly_view', 'weekly_view', 'monthly_view'];

    /**
     * Setup the fixtures.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->entityManagerMock = $this->createMock(EntityManager::class);
        $this->requestStack = new RequestStack();
        $this->viewCounterEntity = new ViewCounterEntity();
        $this->viewDate = new \DateTime('now');
        $this->viewCounterInterfaceMock = $this->createMock(ViewCounterInterface::class);
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        $this->entityManagerMock = null;
        $this->requestStack = null;
        $this->viewCounterEntity = null;
        $this->viewDate = null;
        $this->viewCounterInterfaceMock = null;
    }

    /**
     * tests ViewCounterService
     *
     * @return ViewCounter
     */
    public function testViewCounterService()
    {
        $viewCounterService = new ViewCounter($this->entityManagerMock, $this->requestStack, $this->viewInterval);

        $this->assertInstanceOf(ViewCounter::class, $viewCounterService);

        return $viewCounterService;
    }

    /**
     * @depends testViewCounterService
     */
    public function testIsNewView($viewCounterService)
    {
        $bool = $viewCounterService->isNewView($this->viewCounterInterfaceMock);

        $this->assertTrue(is_bool($bool));
    }
}
