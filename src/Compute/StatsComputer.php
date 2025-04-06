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

namespace Tchoulom\ViewCounterBundle\Compute;

/**
 * Class StatsComputer
 */
class StatsComputer
{
    /**
     * Computes the min value of the statistics.
     *
     * @param array $stats
     *
     * @return array|mixed|null
     */
    public function computeMinValue(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        array_multisort(array_map(fn($element) => $element[1], $stats), SORT_ASC, $stats);

        $minValues = [];
        $min = $stats[0];
        foreach ($stats as $statsPoint) {
            if ($statsPoint[1] > $min[1]) {
                break;
            }

            $minValues[] = $statsPoint;
        }

        if (count($minValues) == 1) {
            $minValues = $min;
        }

        return $minValues;
    }

    /**
     * Computes the max value of the statistics.
     *
     * @param array $stats
     *
     * @return array|mixed|null
     */
    public function computeMaxValue(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        array_multisort(array_map(fn($element) => $element[1], $stats), SORT_DESC, $stats);

        $maxValues = [];
        $max = $stats[0];
        foreach ($stats as $statsPoint) {
            if ($statsPoint[1] < $max[1]) {
                break;
            }

            $maxValues[] = $statsPoint;
        }

        if (count($maxValues) == 1) {
            $maxValues = $max;
        }

        return $maxValues;
    }

    /**
     * Computes the average of the statistics.
     * The average is the sum of the values ​​of the statistical series divided by the number of values.
     *
     * @param array $stats
     *
     * @return float|int|null
     */
    public function computeAverage(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        $statsValues = array_map(fn($statsPoint) => $statsPoint[1], $stats);

        $average = array_sum($statsValues) / count($statsValues);

        return $average;
    }

    /**
     * Computes the range of the statistics.
     * The range is the difference between the highest number and the lowest number.
     *
     * @param array $stats
     *
     * @return mixed|null
     */
    public function computeRange(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        $statsValues = array_map(fn($statsPoint) => $statsPoint[1], $stats);

        $max = max($statsValues);
        $min = min($statsValues);
        $range = $max - $min;

        return $range;
    }

    /**
     * Computes the mode of the statistics.
     * The mode is the number that is in the array the most times.
     *
     * @param array $stats
     *
     * @return mixed|null
     */
    public function computeMode(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        $statsValues = array_map(fn($statsPoint) => $statsPoint[1], $stats);

        $statsValuesCount = array_count_values($statsValues);
        $mode = array_search(max($statsValuesCount), $statsValuesCount);

        return $mode;
    }

    /**
     * Computes the median of the statistics.
     * The median is the middle value after the numbers are sorted smallest to largest.
     *
     * @param array $stats
     *
     * @return float|int|null
     */
    public function computeMedian(array $stats)
    {
        if (empty($stats)) {
            return null;
        }

        $statsValues = array_map(fn($statsPoint) => $statsPoint[1], $stats);

        sort($statsValues);

        $statsValuesCount = count($statsValues);
        $statsValuesMaxKey = $statsValuesCount - 1;

        if (0 == $statsValuesCount % 2) {
            $medianKey1 = $statsValuesMaxKey / 2;
            $medianKey2 = $medianKey1 + 1;

            $median1 = $statsValues[$medianKey1];
            $median2 = $statsValues[$medianKey2];
            $median = ($median1 + $median2) / 2;
        } else {
            $medianKey = $statsValuesMaxKey / 2;
            $median = $statsValues[$medianKey];
        }

        return $median;
    }

    /**
     * Count the number of values in the statistical series.
     *
     * @param array $stats
     *
     * @return int
     */
    public function count(array $stats)
    {
        return count($stats);
    }
}
