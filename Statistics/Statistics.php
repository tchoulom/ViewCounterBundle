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

namespace Tchoulom\ViewCounterBundle\Statistics;

use Tchoulom\ViewCounterBundle\Filesystem\FilesystemInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class Statistics is used to build statistics.
 */
class Statistics
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Statistics constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param ViewCountable $page
     */
    public function register(ViewCountable $page)
    {
        $stats = $this->build($page);
        $this->doRegister($stats);
    }

    /**
     * Builds the statistics of the page.
     *
     * @param ViewCountable $page
     *
     * @return array The statistics
     */
    public function build(ViewCountable $page)
    {
        $class = (new ReflectionExtractor())->getClassNamePluralized($page);
        $pageId = $page->getId();
        $contents = $this->filesystem->loadContents();
        $statsBuilder = (new StatsBuilder($contents, $class))->build($pageId);
        $stats = $statsBuilder->getStats();

        return $stats;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param array $stats
     */
    public function doRegister(array $stats)
    {
        $this->filesystem->save(serialize($stats));
    }
}