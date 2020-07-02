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
    public function getShortClassName($class): string
    {
        return (new \ReflectionClass($class))->getShortName();
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
    public function getClassName($class): string
    {
        return strtolower($this->getShortClassName($class));
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
    public function getClassNamePluralized($class): string
    {
        return $this->getClassName($class) . 's';
    }
}
