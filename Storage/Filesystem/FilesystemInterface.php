<?php

namespace Tchoulom\ViewCounterBundle\Storage\Filesystem;


/**
 * Class Filesystem is used to manipulate the file system.
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