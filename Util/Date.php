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
 * Class Date
 */
class Date
{
    const TIME_ZONE = 'Europe/Paris';

    /**
     * Gets the now DateTime.
     *
     * @param null $timeZone
     *
     * @return \DateTime
     */
    public static function getNowDate($timeZone = null)
    {
        return new \DateTime('now', self::getDateTimeZone($timeZone));
    }

    /**
     * Gets the DateTimeZone.
     *
     * @param null $timeZone
     *
     * @return \DateTimeZone
     */
    public static function getDateTimeZone($timeZone = null)
    {
        $timeZone = null == $timeZone ? self::TIME_ZONE : $timeZone;
        $dateTimeZone = new \DateTimeZone($timeZone);

        return $dateTimeZone;
    }
}
