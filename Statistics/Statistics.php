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

use Tchoulom\ViewCounterBundle\Manager\FileManagerInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class Statistics is used to build statistics.
 */
class Statistics
{
    /**
     * @var FileManagerInterface
     */
    protected $fileManager;

    /**
     * Statistics constructor.
     *
     * @param FileManagerInterface $fileManager
     */
    public function __construct(FileManagerInterface $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * Registers the statistics of the page.
     *
     * @param ViewCountable $page
     *
     * @throws \ReflectionException
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
     * @return array
     *
     * @throws \ReflectionException
     */
    public function build(ViewCountable $page): array
    {
        $class = (new ReflectionExtractor())->getClassNamePluralized($page);
        $pageId = $page->getId();
        $contents = $this->fileManager->loadContents();
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
        $this->fileManager->save(serialize($stats));
    }
}