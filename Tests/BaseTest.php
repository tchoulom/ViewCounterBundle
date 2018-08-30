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
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Persister\Persister;
use Tchoulom\ViewCounterBundle\Persister\PersisterInterface;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter;

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
        $persister = new Persister($this->entityManagerMock);
        $viewCounterService = new ViewCounter($persister, $this->requestStack, $this->viewInterval);

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
     * tests Persister
     *
     * @return Persister
     */
    public function testPersister()
    {
        $persister = new Persister($this->entityManagerMock);

        $this->assertInstanceOf(PersisterInterface::class, $persister);

        return $persister;
    }
}
