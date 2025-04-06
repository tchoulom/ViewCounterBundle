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

use Tchoulom\ViewCounterBundle\Counter\ViewCounter;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class ViewCounterTest
 */
class ViewCounterTest extends AbstractViewCounterTest
{
    /**
     * Setup the fixtures.
     */
    #[\Override]
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown
     */
    #[\Override]
    public function tearDown()
    {
    }

    /**
     * isNewViewDataProvider.
     *
     * @return array
     */
    public function isNewViewDataProvider()
    {
        return [
            [null, '', true],
            ['', self::ON_REFRESH, true],
            ['2019-09-24 11:18:11', self::UNIQUE_VIEW, false],
            ['2019-09-24 11:18:11', self::DAILY_VIEW, false],
            ['2019-09-24 11:18:11', self::DAILY_VIEW, true],
            ['2019-09-24 11:18:11', self::HOURLY_VIEW, false],
            ['2019-09-24 11:18:11', self::HOURLY_VIEW, true],
            ['2019-09-24 11:18:11', self::WEEKLY_VIEW, false],
            ['2019-09-24 11:18:11', self::WEEKLY_VIEW, true],
            ['2019-09-24 11:18:11', self::MONTHLY_VIEW, false],
            ['2019-09-24 11:18:11', self::MONTHLY_VIEW, true],
            ['2019-09-24 11:18:11', self::YEARLY_VIEW, false],
            ['2019-09-24 11:18:11', self::YEARLY_VIEW, true],
            ['2019-09-24 11:18:11', self::VIEW_PER_MINUTE, false],
            ['2019-09-24 11:18:11', self::VIEW_PER_MINUTE, true],
            ['2019-09-24 11:18:11', self::VIEW_PER_SECOND, false],
            ['2019-09-24 11:18:11', self::VIEW_PER_SECOND, true],
            ['2019-09-24 11:18:11', 'No view strategy', false],
        ];
    }

    /**
     * tests isNewView.
     *
     * @dataProvider isNewViewDataProvider
     */
    public function testIsNewView($viewDate, $viewStrategy, $isNewViewResultExpected)
    {
        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(['loadViewCounter', 'getViewStrategy', 'isNewDailyView', 'isNewHourlyView', 'isNewWeeklyView', 'isNewMonthlyView', 'isNewYearlyView', 'isViewPerMinute', 'isViewPerSecond'])
            ->disableOriginalConstructor()
            ->getMock();

        $canGetStrategy = null != $viewDate ? true : false;

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy ? 1 : 0))
            ->method('getViewStrategy')
            ->with()
            ->willReturn($viewStrategy);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::DAILY_VIEW == $viewStrategy ? 1 : 0))
            ->method('isNewDailyView')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::HOURLY_VIEW == $viewStrategy ? 1 : 0))
            ->method('isNewHourlyView')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::WEEKLY_VIEW == $viewStrategy ? 1 : 0))
            ->method('isNewWeeklyView')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::MONTHLY_VIEW == $viewStrategy ? 1 : 0))
            ->method('isNewMonthlyView')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::YEARLY_VIEW == $viewStrategy ? 1 : 0))
            ->method('isNewYearlyView')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::VIEW_PER_MINUTE == $viewStrategy ? 1 : 0))
            ->method('isViewPerMinute')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $viewCounterServiceMock
            ->expects($this->exactly($canGetStrategy && self::VIEW_PER_SECOND == $viewStrategy ? 1 : 0))
            ->method('isViewPerSecond')
            ->with($this->viewCounterEntityMock)
            ->willReturn($isNewViewResultExpected);

        $isNewViewResult = $viewCounterServiceMock->isNewView($this->viewCounterEntityMock);

        $this->assertTrue($isNewViewResultExpected === $isNewViewResult);
    }

    /**
     * isNewDailyViewDataProvider.
     *
     * @return array
     */
    public function isNewDailyViewDataProvider()
    {
        return [
            ['yesterday', true],
            ['today', false],
            ['tomorrow', false],
        ];
    }

    /**
     * tests isNewDailyView.
     *
     * @dataProvider isNewDailyViewDataProvider
     */
    public function testIsNewDailyView($viewDateSTring, $isNewDailyViewResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewDailyView = $this->invokeMethod($viewCounterServiceMock, 'isNewDailyView', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewDailyViewResultExpected === $isNewDailyView);
    }

    /**
     * isNewHourlyViewDataProvider.
     *
     * @return array
     */
    public function isNewHourlyViewDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['yesterday', true, true],
            ['yesterday', false, true],
            ['yesterday', null, true],
            ['tomorrow', true, false],
            ['tomorrow', false, false],
            ['tomorrow', null, false],
        ];
    }

    /**
     * tests isNewHourlyView.
     *
     * @dataProvider isNewHourlyViewDataProvider
     */
    public function testIsNewHourlyView($viewDateSTring, $canAdd1Hour, $isNewHourlyViewResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);
        if (true === $canAdd1Hour) {
            // Add 1 Hour
            $viewDate = Date::getNextHour($viewDate);
        } elseif (false === $canAdd1Hour) {
            // Subtract 1 Hour
            $viewDate = Date::getPreviousHour($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewHourlyView = $this->invokeMethod($viewCounterServiceMock, 'isNewHourlyView', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewHourlyViewResultExpected === $isNewHourlyView);
    }

    /**
     * isNewWeeklyViewDataProvider.
     *
     * @return array
     */
    public function isNewWeeklyViewDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['-1 weeks', false, true],
            ['-1 weeks', true, false],
            ['-1 weeks', null, true],
            ['+1 weeks', false, false],
            ['+1 weeks', true, false],
            ['+1 weeks', null, false],
        ];
    }

    /**
     * tests isNewWeeklyView.
     *
     * @dataProvider isNewWeeklyViewDataProvider
     */
    public function testIsNewWeeklyView($viewDateSTring, $canAdd1Week, $isNewWeeklyViewResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);
        if (true === $canAdd1Week) {
            // Add 1 Week
            $viewDate = Date::getNextWeek($viewDate);
        } elseif (false === $canAdd1Week) {
            // Subtract 1 Week
            $viewDate = Date::getPreviousWeek($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewWeeklyView = $this->invokeMethod($viewCounterServiceMock, 'isNewWeeklyView', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewWeeklyViewResultExpected === $isNewWeeklyView);
    }

    /**
     * isNewMonthlyViewDataProvider.
     *
     * @return array
     */
    public function isNewMonthlyViewDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['-1 month', false, true],
            ['-1 month', true, false],
            ['-1 month', null, true],
            ['+1 month', false, false],
            ['+1 month', true, false],
            ['+1 month', null, false],
        ];
    }

    /**
     * tests isNewMonthlyView.
     *
     * @dataProvider isNewMonthlyViewDataProvider
     */
    public function testIsNewMonthlyView($viewDateSTring, $canAdd1Month, $isNewMonthlyViewResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);
        if (true === $canAdd1Month) {
            // Add 1 Month
            $viewDate = Date::getNextMonth($viewDate);
        } elseif (false === $canAdd1Month) {
            // Subtract 1 Month
            $viewDate = Date::getPreviousMonth($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewMonthlyView = $this->invokeMethod($viewCounterServiceMock, 'isNewMonthlyView', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewMonthlyViewResultExpected === $isNewMonthlyView);
    }

    /**
     * isNewYearlyViewDataProvider.
     *
     * @return array
     */
    public function isNewYearlyViewDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['-1 year', false, true],
            ['-1 year', true, false],
            ['-1 year', null, true],
            ['+1 year', false, false],
            ['+1 year', true, false],
            ['+1 year', null, false],
        ];
    }

    /**
     * tests isNewYearlyView.
     *
     * @dataProvider isNewYearlyViewDataProvider
     */
    public function testIsNewYearlyView($viewDateSTring, $canAdd1Year, $isNewYearlyViewResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);
        if (true === $canAdd1Year) {
            // Add 1 Month
            $viewDate = Date::getNextYear($viewDate);
        } elseif (false === $canAdd1Year) {
            // Subtract 1 Month
            $viewDate = Date::getPreviousYear($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewYearlyView = $this->invokeMethod($viewCounterServiceMock, 'isNewYearlyView', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewYearlyViewResultExpected === $isNewYearlyView);
    }

    /**
     * isNewViewPerMinuteDataProvider.
     *
     * @return array
     */
    public function isNewViewPerMinuteDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['-1 minute', false, true],
            ['-1 minute', true, false],
            ['-1 minute', null, true],
            ['+1 minute', false, false],
            ['+1 minute', true, false],
            ['+1 minute', null, false],
        ];
    }

    /**
     * tests isNewViewPerMinute.
     *
     * @dataProvider isNewViewPerMinuteDataProvider
     */
    public function testIsNewViewPerMinute($viewDateSTring, $canAdd1Minute, $isNewViewPerMinuteResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);

        if (true === $canAdd1Minute) {
            // Add 1 Minute
            $viewDate = Date::getNextMinute($viewDate);
        } elseif (false === $canAdd1Minute) {
            // Subtract 1 Minute
            $viewDate = Date::getPreviousMinute($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewViewPerMinute = $this->invokeMethod($viewCounterServiceMock, 'isViewPerMinute', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewViewPerMinuteResultExpected === $isNewViewPerMinute);
    }

    /**
     * isNewViewPerSecondDataProvider.
     *
     * @return array
     */
    public function isNewViewPerSecondDataProvider()
    {
        return [
            ['now', true, false],
            ['now', false, true],
            ['now', null, false],
            ['-1 second', false, true],
            ['-1 second', true, false],
            ['-1 second', null, true],
            ['+1 second', false, false],
            ['+1 second', true, false],
            ['+1 second', null, false],
        ];
    }

    /**
     * tests isNewViewPerSecond.
     *
     * @dataProvider isNewViewPerSecondDataProvider
     */
    public function testIsNewViewPerSecond($viewDateSTring, $canAdd1Second, $isNewViewPerSecondResultExpected)
    {
        $viewDate = new \DateTime($viewDateSTring);

        if (true === $canAdd1Second) {
            // Add 1 Second
            $viewDate = Date::getNextSecond($viewDate);
        } elseif (false === $canAdd1Second) {
            // Subtract 1 Second
            $viewDate = Date::getPreviousSecond($viewDate);
        }

        $viewCounterServiceMock = $this->getMockBuilder(ViewCounter::class)
            ->setMethods(null)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewCounterEntityMock
            ->expects($this->once())
            ->method('getViewDate')
            ->with()
            ->willReturn($viewDate);

        $isNewViewPerSecond = $this->invokeMethod($viewCounterServiceMock, 'isViewPerSecond', [$this->viewCounterEntityMock]);

        $this->assertTrue($isNewViewPerSecondResultExpected === $isNewViewPerSecond);
    }
}
