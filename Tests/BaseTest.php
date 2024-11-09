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

namespace Tchoulom\ViewCounterBundle\Tests;

use PHPUnit\Framework\TestCase;
use Tchoulom\ViewCounterBundle\Storage\Filesystem\FilesystemStorageInterface;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{
    protected $clientIP = '127.0.0.1';
    protected $filesystemStorageMock;
    protected $viewInterval = ['on_refresh', 'daily_view', 'unique_view', 'hourly_view', 'weekly_view', 'monthly_view', 'yearly_view', 'view_per_minute', 'view_per_second'];

    /**
     * Setup the fixtures.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->filesystemStorageMock = $this->createMock(FilesystemStorageInterface::class);
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        $this->filesystemStorageMock = null;
    }

    /**
     * Invokes a method.
     *
     * @param $object
     * @param $methodName
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    public function invokeMethod($object, $methodName, array $arguments = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $arguments);
    }

    /**
     * Sets a protected property on a given object via reflection
     *
     * @param $object Instance in which protected value is being modified
     * @param $property Property on instance being modified
     * @param $value New value of the property being modified
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function setProtectedProperty($object, $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
}
