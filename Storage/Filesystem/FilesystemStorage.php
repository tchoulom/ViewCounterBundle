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

use Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface;
use Tchoulom\ViewCounterBundle\Builder\FileStatsBuilder;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Exception\IOException;
use Tchoulom\ViewCounterBundle\Exception\IOExceptionInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class FilesystemStorage is used to save statistics in a file system.
 */
class FilesystemStorage implements FilesystemStorageInterface, StorageAdapterInterface
{
    /**
     * @var string The Permission message.
     */
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
     * The File Stats Builder.
     *
     * @var FileStatsBuilder
     */
    protected $fileStatsBuilder;

    /**
     * @var string The viewcounter directory.
     */
    protected $viewcounterDir = 'viewcounter';

    /**
     * @var string The stats file name.
     */
    protected $filename = 'stats';

    /**
     * FilesystemStorage constructor.
     *
     * @param $projectDir
     * @param ViewcounterConfig $viewcounterConfig
     * @param FileStatsBuilder $fileStatsBuilder
     */
    public function __construct($projectDir, ViewcounterConfig $viewcounterConfig, FileStatsBuilder $fileStatsBuilder)
    {
        $this->projectDir = $projectDir;
        $this->viewcounterConfig = $viewcounterConfig;
        $this->fileStatsBuilder = $fileStatsBuilder;
    }

    /**
     * Saves the statistics.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @throws \ReflectionException
     */
    public function save(ViewCounterInterface $viewcounter)
    {
        $stats = $this->build($viewcounter);

        $stats = serialize($stats);
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
     * Builds the statistics of the page.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return array                            The stats.
     *
     * @throws \ReflectionException
     */
    public function build(ViewCounterInterface $viewcounter): array
    {
        $contents = $this->loadContents();
        $statBuilder = $this->fileStatsBuilder->build($contents, $viewcounter);
        $stats = $statBuilder->getStats();

        return $stats;
    }

    /**
     * Loads the contents.
     *
     * @return mixed
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
            throw new IOException(sprintf('An error occurred while loading the stats file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"',
                $this->getFullStatsFileName(), $exception->getMessage()));
        }

        $contents = empty($contents) ? [] : unserialize($contents);

        return $contents;
    }

    /**
     * Gets the stats file name.
     *
     * @return string
     */
    public function getStatsFileName(): string
    {
        $filename = $this->viewcounterConfig->getStatisticsNodeConfig()->getStatsFileName();
        $filename = (null != $filename) ? $filename : $this->filename;

        return $filename;
    }

    /**
     * Gets the stats file extension.
     *
     * @return string|null
     */
    public function getStatsFileExtension(): ?string
    {
        return $this->viewcounterConfig->getStatisticsNodeConfig()->getStatsFileExtension();
    }

    /**
     * Gets the full stats file name.
     *
     * @return string
     */
    public function getFullStatsFileName(): string
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
    public function getViewcounterDir(): string
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
            throw new IOException(sprintf('An error occurred while attempting to create the directory: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"',
                $this->getViewcounterDir(), $exception->getMessage()));
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
            throw new IOException(sprintf('An error occurred while attempting to open the file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"',
                $this->getFullStatsFileName(), $exception->getMessage()));
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
            throw new IOException(sprintf('An error occurred while attempting to write to file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"',
                $this->getFullStatsFileName(), $exception->getMessage()));
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
            throw new IOException(sprintf('An error occurred while attempting to close output file: "%s" ' . self::CHECK_PERMISSIONS_MSG . '. "%s"',
                $this->getFullStatsFileName(), $exception->getMessage()));
        }
    }
}
