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

namespace Tchoulom\ViewCounterBundle\Storage\Filesystem;


use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * Class FilesystemStorageInterface is used to manipulate the file system.
 */
interface FilesystemStorageInterface
{
    /**
     * Saves the statistics.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     */
    public function save(ViewCounterInterface $viewcounter);

    /**
     * Loads the contents.
     *
     * @return mixed
     */
    public function loadContents();

    /**
     * Gets the stats file name.
     *
     * @return string
     */
    public function getStatsFileName(): string;

    /**
     * Gets the stats file extension.
     *
     * @return string|null
     */
    public function getStatsFileExtension(): ?string;

    /**
     * Gets the full stats file name.
     *
     * @return string
     */
    public function getFullStatsFileName(): string;

    /**
     * Gets the viewcounter directory.
     *
     * @return string
     */
    public function getViewcounterDir(): string;

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
