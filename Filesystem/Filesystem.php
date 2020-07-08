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

use Tchoulom\ViewCounterBundle\Exception\IOException;
use Tchoulom\ViewCounterBundle\Exception\IOExceptionInterface;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;

/**
 * Class Filesystem is used to manipulate the file system.
 */
class Filesystem implements FilesystemInterface
{
    const CHECK_PERMISSIONS_MSG = '(Please check User and Group permissions)';

    /**
     * The project directory.
     *
     */
    protected $projectDir;

    /**
     * The View counter configs.
     *
     * @var ViewcounterConfig
     */
    protected $viewcounterConfig;

    /**
     * @var string The viewcounter directory.
     */
    protected $viewcounterDir = 'viewcounter';

    /**
     * @var string The stats file name.
     */
    protected $filename = 'stats';

    /**
     * Filesystem constructor.
     *
     * @param $projectDir
     * @param ViewcounterConfig $viewcounterConfig
     */
    public function __construct($projectDir, ViewcounterConfig $viewcounterConfig)
    {
        $this->projectDir = $projectDir;
        $this->viewcounterConfig = $viewcounterConfig;
    }

    /**
     * Saves the statistics.
     *
     * @param $stats
     */
    public function save($stats)
    {
        $dirname = $this->getViewcounterDir();
        $filename = $this->getFullStatsFileName();

        if (!file_exists($dirname) && !is_dir($dirname)) {
            $this->mkdir($dirname);
            $file = $this->fopen($filename);
            $this->fwrite($file, $stats);
            $this->fclose($file);
        } else {
            $file = $this->fopen($filename);
            $this->fwrite($file, $stats);
            $this->fclose($file);
        }
    }

    /**
     * Loads the contents.
     *
     * @return array|bool|mixed|string
     */
    public function loadContents()
    {
        $filename = $this->getFullStatsFileName();
        $contents = [];

        if (!file_exists($filename)) {
            return $contents;
        }

        try {
            $contents = file_get_contents($filename);
        } catch (IOExceptionInterface $exception) {
            throw new IOException(sprintf('An error occurred while loading the stats file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"', $this->getFullStatsFileName(), $exception->getMessage()));
        }

        $contents = empty($contents) ? [] : unserialize($contents);

        return $contents;
    }

    /**
     * Gets the stats file name.
     *
     * @return mixed|string
     */
    public function getStatsFileName()
    {
        $filename = $this->viewcounterConfig->getStatisticsNodeConfig()->getStatsFileName();
        $filename = (null != $filename) ? $filename : $this->filename;

        return $filename;
    }

    /**
     * Gets the stats file extension.
     *
     * @return mixed
     */
    public function getStatsFileExtension()
    {
        return $this->viewcounterConfig->getStatisticsNodeConfig()->getStatsFileExtension();
    }

    /**
     * Gets the full stats file name.
     *
     * @return string
     */
    public function getFullStatsFileName()
    {
        $ext = $this->getStatsFileExtension();
        $extension = null != $ext ? '.' . $ext : '';

        return $this->getViewcounterDir() . '/' . $this->getStatsFileName() . $extension;
    }

    /**
     * Gets the viewcounter directory.
     *
     * @return string
     */
    public function getViewcounterDir()
    {
        return $this->projectDir . '/var/' . $this->viewcounterDir;
    }

    /**
     * Creates a directory.
     *
     * @param $dirname
     * @param int $mode
     * @param bool $recursive
     */
    public function mkdir($dirname, $mode = 0777, $recursive = true)
    {
        try {
            mkdir($dirname, $mode, $recursive);
        } catch (IOExceptionInterface $exception) {
            throw new IOException(sprintf('An error occurred while attempting to create the directory: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"', $this->getViewcounterDir(), $exception->getMessage()));
        }
    }

    /**
     * Opens a file.
     *
     * @param $filename
     * @param string $mode
     *
     * @return bool|resource
     */
    public function fopen($filename, $mode = 'w')
    {
        try {
            $file = fopen($filename, $mode);
        } catch (IOExceptionInterface $exception) {
            throw new IOException(sprintf('An error occurred while attempting to open the file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"', $this->getFullStatsFileName(), $exception->getMessage()));
        }

        return $file;
    }

    /**
     * Writes to file.
     *
     * @param $file
     * @param $stats
     */
    public function fwrite($file, $stats)
    {
        try {
            fwrite($file, $stats);
        } catch (IOExceptionInterface $exception) {
            throw new IOException(sprintf('An error occurred while attempting to write to file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"', $this->getFullStatsFileName(), $exception->getMessage()));
        }
    }

    /**
     * Closes an output file.
     *
     * @param $file
     */
    public function fclose($file)
    {
        try {
            fclose($file);
        } catch (IOExceptionInterface $exception) {
            throw new IOException(sprintf('An error occurred while attempting to close output file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"', $this->getFullStatsFileName(), $exception->getMessage()));
        }
    }
}