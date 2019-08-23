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

namespace Tchoulom\ViewCounterBundle\Tests;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounter as ViewCounterEntity;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter;
use Tchoulom\ViewCounterBundle\Repository\CounterRepository;
use Tchoulom\ViewCounterBundle\Repository\RepositoryInterface;

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
    protected $viewInterval = ['increment_each_view', 'daily_view', 'unique_view', 'hourly_view', 'weekly_view', 'monthly_view', 'yearly_view'];

    /**
     * Setup the fixtures.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->viewCountableMock = $this->createMock(ViewCountable::class);
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
     * tests viewCounterService
     *
     * @return ViewCounter
     */
    public function testViewCounterService()
    {
        $counterRepository = new CounterRepository($this->entityManagerMock);
        $counterManager = new CounterManager($counterRepository);
        $viewCounterService = new ViewCounter($counterManager, $this->requestStack, $this->viewInterval);

        $this->assertInstanceOf(ViewCounter::class, $viewCounterService);

        return $viewCounterService;
    }

    /**
     * tests isNewView
     *
     * @depends testViewCounterService
     */
    public function testIsNewView($viewCounterService)
    {
        $bool = $viewCounterService->isNewView($this->viewCounterInterfaceMock);

        $this->assertTrue(is_bool($bool));
    }

    /**
     * Tests CounterRepository.
     *
     * @return CounterRepository
     */
    public function testCounterRepository()
    {
        $counterRepository = new CounterRepository($this->entityManagerMock);

        $this->assertInstanceOf(RepositoryInterface::class, $counterRepository);

        return $counterRepository;
    }
}
