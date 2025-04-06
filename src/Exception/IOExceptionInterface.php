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

namespace Tchoulom\ViewCounterBundle\Exception;

/**
 * Interface IOExceptionInterface
 */
interface IOExceptionInterface extends ExceptionInterface
{
    /**
     * Returns the path for the exception.
     *
     * @return string The path for the exception
     */
    public function getPath();
}
