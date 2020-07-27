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
     * The Filesystem service.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * The Statistics builder.
     *
     * @var StatsBuilder
     */
    protected $statsBuilder;

    /**
     * Statistics constructor.
     *
     * @param FilesystemInterface $filesystem
     * @param StatsBuilder $statsBuilder
     */
    public function __construct(FilesystemInterface $filesystem, StatsBuilder $statsBuilder)
    {
        $this->filesystem = $filesystem;
        $this->statsBuilder = $statsBuilder;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param ViewCountable $page
     *
     * @throws \ReflectionException
     */
    public function register(ViewCountable $page): void
    {
        $stats = $this->build($page);
        $this->doRegister($stats);
    }

    /**
     * Builds the statistics of the page.
     *
     * @param ViewCountable $page
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function build(ViewCountable $page): array
    {
        $class = ReflectionExtractor::getClassNamePluralized($page);
        $contents = $this->filesystem->loadContents();
        $statsBuilder = $this->statsBuilder->build($contents, $class, $page->getId());
        $stats = $statsBuilder->getStats();

        return $stats;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param array $stats
     */
    public function doRegister(array $stats): void
    {
        $this->filesystem->save(serialize($stats));
    }
}
