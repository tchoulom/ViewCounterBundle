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
     * Generates now DateTime
     *
     * @return \DateTime
     */
    public static function getNowDate()
    {
        return self::getDate('now');
    }

    /**
     * Generates date with good configuration
     *
     * @param string $date
     *
     * @return \DateTime
     */
    public static function getDate($date)
    {
        return new \DateTime($date, self::getDateTimeZone());
    }

    /**
     * Gets DateTimeZone
     *
     * @return \DateTimeZone
     */
    public static function getDateTimeZone()
    {
        static $dateTimeZone = null;

        if (null == $dateTimeZone) {
            $dateTimeZone = new \DateTimeZone(self::TIME_ZONE);
        }

        return $dateTimeZone;
    }
}
