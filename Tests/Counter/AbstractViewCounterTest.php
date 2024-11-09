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

namespace Tchoulom\ViewCounterBundle\Tests\Counter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Counter\AbstractViewCounter;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Model\StatisticsNodeConfig;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Counter\ViewCounter;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;
use Tchoulom\ViewCounterBundle\Model\ViewcounterNodeConfig;
use Tchoulom\ViewCounterBundle\Statistics\Statistics;
use Tchoulom\ViewCounterBundle\Manager\StatsManager;
use Tchoulom\ViewCounterBundle\Tests\BaseTest;

/**
 * Class AbstractViewCounterTest
 */
class AbstractViewCounterTest extends BaseTest
{
    protected $viewDate = null;
    protected $property = 'course';
    protected $class = 'Blog\BlogBundle\Entity\ViewCounter';
    protected $pageMock = null;
    protected $request;
    protected $requestMock;
    protected $requestStack;
    protected $requestStackMock;
    protected $statsManagerMock;
    protected $viewCounterEntityClass = 'Blog\BlogBundle\Entity\ViewCounter';
    protected $viewCounterEntityMock;
    protected $counterManagerMock;
    protected $viewcounterConfigMock;
    protected $viewcounterNodeConfigMock;
    protected $statisticsNodeConfigMock;
    protected $viewStrategy = 'view_per_minute';
    protected $viewInterval = ['on_refresh', 'daily_view', 'unique_view', 'hourly_view', 'weekly_view', 'monthly_view', 'yearly_view', 'view_per_minute', 'view_per_second'];

    const ON_REFRESH = 'on_refresh';
    const DAILY_VIEW = 'daily_view';
    const UNIQUE_VIEW = 'unique_view';
    const HOURLY_VIEW = 'hourly_view';
    const WEEKLY_VIEW = 'weekly_view';
    const MONTHLY_VIEW = 'monthly_view';
    const YEARLY_VIEW = 'yearly_view';
    const VIEW_PER_MINUTE = 'view_per_minute';
    const VIEW_PER_SECOND = 'view_per_second';

    /**
     * Setup the fixtures.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->viewDate = new \DateTime('now');
        $this->pageMock = $this->getMockBuilder(ViewCountable::class)
            ->setMethods(['getViews', 'setViews'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->request = new Request();
        $this->requestStackMock = $this->createMock(RequestStack::class);
        $this->requestMock = $this->createMock(Request::class);
        $this->statsManagerMock = $this->createMock(StatsManager::class);
        $this->viewCounterEntityMock = $this->createMock(ViewCounterInterface::class);
        $this->counterManagerMock = $this->createMock(CounterManager::class);
        $this->viewcounterConfigMock = $this->createMock(ViewcounterConfig::class);
        $this->viewcounterNodeConfigMock = $this->createMock(ViewcounterNodeConfig::class);
        $this->statisticsNodeConfigMock = $this->createMock(StatisticsNodeConfig::class);
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        $this->viewDate = null;
        $this->pageMock = null;
        $this->request = null;
        $this->requestStackMock = null;
        $this->requestMock = null;
        $this->statsManagerMock = null;
        $this->viewCounterEntityMock = null;
        $this->counterManagerMock = null;
        $this->viewcounterConfigMock = null;
        $this->viewcounterNodeConfigMock = null;
        $this->statisticsNodeConfigMock = null;
    }

    /**
     * loadViewCounterDataProvider.
     *
     * @return array
     */
    public function loadViewCounterDataProvider()
    {
        return [
            [false],
            [true],
        ];
    }

    /**
     * Tests the loadViewCounter method.
     *
     * @dataProvider loadViewCounterDataProvider
     */
    public function testLoadViewCounter($isInstanceOfViewCounterInterface)
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['getClientIp', 'createViewCounterObject'])
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $this->counterManagerMock
            ->expects($this->once())
            ->method('loadMetadata')
            ->with($this->pageMock)
            ->willReturn($this->counterManagerMock);

        $this->counterManagerMock
            ->expects($this->once())
            ->method('getProperty')
            ->with()
            ->willReturn($this->property);

        $this->counterManagerMock
            ->expects($this->once())
            ->method('getClass')
            ->with()
            ->willReturn($this->class);

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getClientIp')
            ->with()
            ->willReturn($this->clientIP);

        $this->counterManagerMock
            ->expects($this->once())
            ->method('findOneBy')
            ->with([$this->property => $this->pageMock, 'ip' => $this->clientIP], $orderBy = null, $limit = null, $offset = null)
            ->willReturn(false === $isInstanceOfViewCounterInterface ? null : $this->viewCounterEntityMock);

        $viewCounterServiceMock
            ->expects($this->exactly(false === $isInstanceOfViewCounterInterface ? 1 : 0))
            ->method('createViewCounterObject')
            ->with()
            ->willReturn($this->viewCounterEntityMock);

        $viewCounterInterface = $this->invokeMethod($viewCounterServiceMock, 'loadViewCounter', [$this->pageMock]);

        $this->assertTrue($viewCounterInterface instanceof ViewCounterInterface);
    }

    /**
     * getViewCounterDataProvider.
     *
     * @return array
     */
    public function getViewCounterDataProvider()
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * Tests the getViewCounter method.
     *
     * @dataProvider getViewCounterDataProvider
     */
    public function testGetViewCounter($isInstanceOfViewCounterInterface)
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['loadViewCounter'])
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('loadViewCounter')
            ->with($this->pageMock)
            ->willReturn(true === $isInstanceOfViewCounterInterface ? $this->viewCounterEntityMock : null);

        $viewCounterInterface = $viewCounterServiceMock->getViewCounter($this->pageMock);

        if (true === $isInstanceOfViewCounterInterface) {
            $this->assertTrue($viewCounterInterface instanceof ViewCounterInterface);
        } else {
            $this->assertNull($viewCounterInterface);
        }
    }

    /**
     * getViewsDataProvider.
     *
     * @return array
     */
    public function getViewsDataProvider()
    {
        return [
            [false, true, 8],
            [true, false, 5],
            [false, false, 0],
            [true, true, 54],
        ];
    }

    /**
     * Tests the getViews method.
     *
     * @dataProvider getViewsDataProvider
     */
    public function testGetViews($isInstanceOfViewCounterInterface, $isNewView, $views)
    {
        $viewsExpected = (false === $isInstanceOfViewCounterInterface || true === $isNewView) ? $views + 1 : $views;

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['getViewCounter', 'isNewView',])
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getViewCounter')
            ->with($this->pageMock)
            ->willReturn(true === $isInstanceOfViewCounterInterface ? $this->viewCounterEntityMock : null);

        $viewCounterServiceMock
            ->expects($this->exactly((true === $isInstanceOfViewCounterInterface) ? 1 : 0))
            ->method('isNewView')
            ->with($this->viewCounterEntityMock)
            ->willReturn(true === $isNewView ? true : false);

        $this->pageMock
            ->expects($this->once())
            ->method('getViews')
            ->with()
            ->willReturn($views);

        $views = $viewCounterServiceMock->getViews($this->pageMock);

        $this->assertEquals($viewsExpected, $views);
    }

    /**
     * saveViewDataProvider.
     *
     * @return array
     */
    public function saveViewDataProvider()
    {
        return [
            [true, true, 45, 'now', true],
            [true, true, 17, 'now', false],
            [true, false, 0, 'now', true],
            [true, false, 21, 'now', false],
        ];
    }

    /**
     * Tests the saveView method.
     *
     * @dataProvider saveViewDataProvider
     */
    public function testSaveView($isInstanceOfViewCounterInterface, $isNewView, $views, $viewDateSTring, $canUseStats)
    {
        $viewDate = new \DateTime($viewDateSTring);
        $viewsExpected = (true === $isNewView) ? $views + 1 : $views;
        $countIsNewView = (true === $isNewView) ? 1 : 0;
        $countCanHandleStatistics = (true === $isNewView && true === $canUseStats) ? 1 : 0;

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['getViewCounter', 'isNewView', 'getViews', 'getClientIp', 'getProperty', 'getNowDate', 'canUseStats', 'handleStatistics'])
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $viewCounterEntityMock = $this->getMockBuilder(\Tchoulom\ViewCounterBundle\Entity\ViewCounter::class)
            ->setMethods(['setIp', 'setCourse', 'setViewDate'])
            ->disableOriginalConstructor()
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getViewCounter')
            ->with($this->pageMock)
            ->willReturn(true === $isInstanceOfViewCounterInterface ? $viewCounterEntityMock : null);

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('isNewView')
            ->with($viewCounterEntityMock)
            ->willReturn(true === $isNewView ? true : false);

        $viewCounterServiceMock
            ->expects($this->exactly($countIsNewView))
            ->method('getViews')
            ->with($this->pageMock)
            ->willReturn($viewsExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($countIsNewView))
            ->method('getClientIp')
            ->with()
            ->willReturn($this->clientIP);

        $viewCounterEntityMock
            ->expects($this->exactly($countIsNewView))
            ->method('setIp')
            ->with($this->clientIP)
            ->willReturn($viewCounterEntityMock);

        $viewCounterServiceMock
            ->expects($this->exactly($countIsNewView))
            ->method('getProperty')
            ->with()
            ->willReturn(ucfirst('course'));

        $viewCounterEntityMock
            ->expects($this->exactly($countIsNewView))
            ->method('setCourse')
            ->with($this->pageMock)
            ->willReturn($viewCounterEntityMock);

        $viewCounterServiceMock
            ->expects($this->exactly($countIsNewView))
            ->method('getNowDate')
            ->with()
            ->willReturn($viewDate);

        $viewCounterEntityMock
            ->expects($this->exactly($countIsNewView))
            ->method('setViewDate')
            ->with($viewDate)
            ->willReturn($viewCounterEntityMock);

        $this->pageMock
            ->expects($this->exactly($countIsNewView))
            ->method('setViews')
            ->with($viewsExpected)
            ->willReturn($this->pageMock);

        $viewCounterServiceMock
            ->expects($this->exactly($countIsNewView))
            ->method('canUseStats')
            ->with()
            ->willReturn($canUseStats);

        $viewCounterServiceMock
            ->expects($this->exactly($countCanHandleStatistics))
            ->method('handleStatistics')
            ->with($viewCounterEntityMock)
            ->willReturn(null);

        $page = $viewCounterServiceMock->saveView($this->pageMock);

        $this->assertEquals($page, $this->pageMock);
        $this->assertTrue($page instanceof ViewCountable);
    }

    /**
     * Tests the handleStatistics method.
     */
    public function testHandleStatistics()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['getProperty'])
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $viewCounterEntityMock = $this->getMockBuilder(\Tchoulom\ViewCounterBundle\Entity\ViewCounter::class)
            ->setMethods(['getCourse'])
            ->disableOriginalConstructor()
            ->getMock();

        $statisticMock = $this->getMockBuilder(Statistics::class)
            ->setConstructorArgs([$this->filesystemStorageMock])
            ->getMock();

        $this->setProtectedProperty($viewCounterServiceMock, 'statistics', $statisticMock);

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getProperty')
            ->with()
            ->willReturn(ucfirst('course'));

        $viewCounterEntityMock
            ->expects($this->once())
            ->method('getCourse')
            ->with()
            ->willReturn($this->pageMock);

        $statisticMock
            ->expects($this->once())
            ->method('register')
            ->with($this->pageMock)
            ->willReturn(null);

        $viewCounterServiceMock->handleStatistics($viewCounterEntityMock);

        $this->assertTrue($this->pageMock instanceof ViewCountable);
    }

    /**
     * Tests the getRequest method.
     */
    public function testGetRequest()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $this->requestStackMock
            ->expects($this->once())
            ->method('getCurrentRequest')
            ->with()
            ->willReturn($this->request);

        $request = $this->invokeMethod($viewCounterServiceMock, 'getRequest', []);

        $this->assertTrue($request instanceof Request);
    }

    /**
     * Tests the getViewStrategy method.
     */
    public function testGetViewStrategy()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $this->viewcounterConfigMock
            ->expects($this->once())
            ->method('getViewcounterNodeConfig')
            ->with()
            ->willReturn($this->viewcounterNodeConfigMock);

        $this->viewcounterNodeConfigMock
            ->expects($this->once())
            ->method('getViewStrategy')
            ->with()
            ->willReturn($this->viewStrategy);

        $viewStrategy = $this->invokeMethod($viewCounterServiceMock, 'getViewStrategy', []);

        $this->assertEquals($this->viewStrategy, $viewStrategy);
    }

    /**
     * Tests the canUseStats method.
     */
    public function testCanUseStats()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->getMock();

        $this->viewcounterConfigMock
            ->expects($this->once())
            ->method('getStatisticsNodeConfig')
            ->with()
            ->willReturn($this->statisticsNodeConfigMock);

        $this->statisticsNodeConfigMock
            ->expects($this->once())
            ->method('canUseStats')
            ->with()
            ->willReturn(true);

        $canUseStats = $this->invokeMethod($viewCounterServiceMock, 'canUseStats', []);

        $this->assertTrue(is_bool($canUseStats));
        $this->assertEquals(true, $canUseStats);
    }

    /**
     * Tests the createViewCounterObject method.
     */
    public function testCreateViewCounterObject()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getClass'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getClass')
            ->with()
            ->willReturn($this->viewCounterEntityClass);

        $viewCounterObject = $this->invokeMethod($viewCounterServiceMock, 'createViewCounterObject', []);

        $this->assertTrue($viewCounterObject instanceof ViewCounterInterface);
    }

    /**
     * Tests the getClass method.
     */
    public function testGetClass()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getClass'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getClass')
            ->with()
            ->willReturn($this->viewCounterEntityMock);

        $viewCounterObject = $this->invokeMethod($viewCounterServiceMock, 'getClass', []);

        $this->assertTrue($viewCounterObject instanceof ViewCounterInterface);
    }

    /**
     * Tests the getProperty method.
     */
    public function testGetProperty()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getProperty'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getProperty')
            ->with()
            ->willReturn($this->property);

        $property = $this->invokeMethod($viewCounterServiceMock, 'getProperty', []);

        $this->assertEquals($this->property, $property);
    }

    /**
     * Tests the setPage method.
     */
    public function testSetPage()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['setPage'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('setPage')
            ->with($this->pageMock)
            ->willReturn($viewCounterServiceMock);

        $viewCounterService = $this->invokeMethod($viewCounterServiceMock, 'setPage', [$this->pageMock]);

        $this->assertTrue($viewCounterService instanceof AbstractViewCounter);
    }

    /**
     * Tests the getPage method.
     */
    public function testGetPage()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getPage'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getPage')
            ->with()
            ->willReturn($this->pageMock);

        $page = $this->invokeMethod($viewCounterServiceMock, 'getPage', []);

        $this->assertTrue($page instanceof ViewCountable);
    }

    /**
     * Tests the getNowDate method.
     */
    public function testGetNowDate()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getPage'])
            ->getMock();

        $nowDate = $this->invokeMethod($viewCounterServiceMock, 'getNowDate', []);

        $this->assertTrue($nowDate instanceof \DateTime);
    }

    /**
     * Tests the getClientIp method.
     */
    public function testGetClientIp()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getRequest'])
            ->getMock();

        $viewCounterServiceMock
            ->expects($this->once())
            ->method('getRequest')
            ->with()
            ->willReturn($this->requestMock);

        $this->requestMock
            ->expects($this->once())
            ->method('getClientIp')
            ->with()
            ->willReturn($this->clientIP);

        $clientIp = $viewCounterServiceMock->getClientIp();

        $this->assertEquals($clientIp, $this->clientIP);
    }

    /**
     * Tests the setStatsManager method.
     */
    public function testSetStatsManager()
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setConstructorArgs([$this->counterManagerMock, $this->requestStackMock, $this->viewcounterConfigMock])
            ->setMethods(['getRequest'])
            ->getMock();

        $viewCounterService = $viewCounterServiceMock->setStatsManager($this->statsManagerMock);

        $this->assertTrue($viewCounterService instanceof AbstractViewCounter);
    }
}
