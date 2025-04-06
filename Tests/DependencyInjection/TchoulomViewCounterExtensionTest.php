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

namespace Tchoulom\ViewCounterBundle\Tests\DependencyInjection;

use Tchoulom\ViewCounterBundle\DependencyInjection\TchoulomViewCounterExtension;
use Tchoulom\ViewCounterBundle\Tests\BaseTest;

/**
 * Class TchoulomViewCounterExtensionTest
 */
class TchoulomViewCounterExtensionTest extends BaseTest
{
    protected $viewCounterExtension;

    /**
     * Setup the fixtures.
     */
    #[\Override]
    protected function setUp()
    {
        parent::setUp();

        $this->viewCounterExtension = new TchoulomViewCounterExtension();
    }

    /**
     * tearDown
     */
    #[\Override]
    public function tearDown()
    {
        parent::tearDown();

        $this->viewCounterExtension = null;
    }

    /**
     * tests postProcessSuccess
     *
     * @dataProvider postProcessProvider
     */
    public function testPostProcessSuccess($configs)
    {
        $uniqueElt = $this->viewCounterExtension->postProcess($configs);

        $this->assertTrue(is_array($uniqueElt));
    }

    /**
     * tests postProcessError
     *
     * @expectedException \Tchoulom\ViewCounterBundle\Exception\RuntimeException
     * @expectedExceptionMessage You must choose one of the following values: on_refresh, unique_view, daily_view, hourly_view, weekly_view, monthly_view, yearly_view, view_per_minute, view_per_second.
     */
    public function testPostProcessError($configs = null)
    {
        $this->viewCounterExtension->postProcess($configs);
    }

    /**
     * @return array
     */
    public function postProcessProvider()
    {
        return [
            [
                [
                    ['view_counter' => ['daily_view' => 1]]
                ]
            ]
        ];
    }
}