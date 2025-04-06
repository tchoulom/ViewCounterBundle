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

namespace Tchoulom\ViewCounterBundle\Util;

/**
 * Class ReflectionExtractor
 */
class ReflectionExtractor
{
    /**
     * Gets the short class name.
     *
     * @param $class
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public static function getShortClassName($class): string
    {
        return new \ReflectionClass($class)->getShortName();
    }

    /**
     * Gets the class name.
     *
     * @param $class
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public static function getClassName($class): string
    {
        return strtolower(self::getShortClassName($class));
    }

    /**
     * Gets the class name pluralized.
     *
     * @param $class
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    public static function getClassNamePluralized($class): string
    {
        return self::getClassName($class) . 's';
    }

    /**
     * Gets the full class name.
     *
     * @param $class
     *
     * @return string The full
     */
    public static function getFullClassName($class): string
    {
        return $class::class;
    }
}
