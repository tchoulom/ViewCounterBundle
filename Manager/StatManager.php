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

namespace Tchoulom\ViewCounterBundle\Manager;

use Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Statistics\StatBuilder;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class StatManager is used to manage statistics.
 */
class StatManager
{
    /**
     * The StorageAdapter service.
     *
     * @var StorageAdapterInterface
     */
    protected $storageAdapter;

    /**
     * The Statistics builder.
     *
     * @var StatBuilder
     */
    protected $statBuilder;

    /**
     * Statistics constructor.
     *
     * @param StorageAdapterInterface $storageAdapter
     * @param StatBuilder $statBuilder
     */
    public function __construct(StorageAdapterInterface $storageAdapter, StatBuilder $statBuilder)
    {
        $this->storageAdapter = $storageAdapter;
        $this->statBuilder = $statBuilder;
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
        $this->storageAdapter->save($stats);
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
        $contents = $this->storageAdapter->loadContents();
        $statBuilder = $this->statBuilder->build($contents, $class, $page->getId());
        $stats = $statBuilder->getStats();

        return $stats;
    }

    /**
     * Converts ViewCounter entities to statistical data.
     *
     * @param array $viewCounterData The data to be converted into statistical data.
     *
     * @throws \ReflectionException
     */
    public function convertToStats(array $viewCounterData)
    {
        $contents = $this->storageAdapter->loadContents();
        foreach ($viewCounterData as $viewCounter) {
            $page = $viewCounter->getPage();
            $class = ReflectionExtractor::getClassNamePluralized($page);
            $statBuilder = $this->statBuilder->build($contents, $class, $page->getId());
            $contents = $statBuilder->getStats();
        }

        $this->storageAdapter->save($contents);
    }
}
