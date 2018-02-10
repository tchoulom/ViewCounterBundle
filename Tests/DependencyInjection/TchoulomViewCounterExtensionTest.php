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
    protected function setUp()
    {
        parent::setUp();

        $this->viewCounterExtension = new TchoulomViewCounterExtension();
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();

        $this->viewCounterExtension = null;
    }

    /**
     * tests beforeProcessSuccess
     *
     * @dataProvider beforeProcessProvider
     */
    public function testBeforeProcessSuccess($configs)
    {
        $uniqueElt = $this->viewCounterExtension->beforeProcess($configs);

        $this->assertTrue(is_array($uniqueElt));
    }

    /**
     * tests beforeProcessError
     * 
     * @expectedException \Tchoulom\ViewCounterBundle\Exception\RuntimeException
     * @expectedExceptionMessage You must choose one of the following values: unique_view, daily_view, hourly_view, weekly_view.
     */
    public function testBeforeProcessError($configs = null)
    {
        $this->viewCounterExtension->beforeProcess($configs);
    }

    /**
     * @return array
     */
    public function beforeProcessProvider()
    {
        return [
            [
                [
                    ['view_interval' => [0 => ['daily_view' => 1]]]
                ]
            ]
        ];
    }
}