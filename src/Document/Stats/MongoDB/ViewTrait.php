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

namespace Tchoulom\ViewCounterBundle\Document\Stats\MongoDB;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Trait ViewTrait
 * 
 * @package Tchoulom\ViewCounterBundle\Document\Stats\MongoDB
 */
trait ViewTrait
{
    #[MongoDB\Field(type: 'integer')]
    protected $views = 0;

    /**
     * Gets Views.
     *
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * Sets views.
     *
     * @param int $views
     *
     * @return self
     */
    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Increase the views.
     *
     * @return self
     */
    public function increaseViews(): self
    {
        $this->setViews(++$this->views);

        return $this;
    }
}
