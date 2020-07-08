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

namespace Tchoulom\ViewCounterBundle\Filesystem;

/**
 * Class FilesystemInterface is used to manipulate the file system.
 */
interface FilesystemInterface
{
    /**
     * Saves the statistics.
     *
     * @param $stats
     */
    public function save($stats);

    /**
     * Loads the contents.
     *
     * @return array|bool|mixed|string
     */
    public function loadContents();

    /**
     * Gets the stats file name.
     *
     * @return mixed|string
     */
    public function getStatsFileName();

    /**
     * Gets the stats file extension.
     *
     * @return mixed
     */
    public function getStatsFileExtension();

    /**
     * Gets the full stats file name.
     *
     * @return string
     */
    public function getFullStatsFileName();

    /**
     * Gets the viewcounter directory.
     *
     * @return string
     */
    public function getViewcounterDir();

    /**
     * Creates a directory.
     *
     * @param $dirname
     * @param int $mode
     * @param bool $recursive
     */
    public function mkdir($dirname, $mode = 0777, $recursive = true);

    /**
     * Opens a file.
     *
     * @param $filename
     * @param string $mode
     *
     * @return bool|resource
     */
    public function fopen($filename, $mode = 'w');

    /**
     * Writes to file.
     *
     * @param $file
     * @param $stats
     */
    public function fwrite($file, $stats);

    /**
     * Closes an output file.
     *
     * @param $file
     */
    public function fclose($file);
}