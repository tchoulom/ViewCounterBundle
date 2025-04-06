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

namespace Tchoulom\ViewCounterBundle\Model;

/**
 * Class ViewcounterNodeConfig
 */
class ViewcounterNodeConfig
{
    /**
     * @var mixed The view strategy
     */
    protected $viewStrategy;

    /**
     * ViewcounterNodeConfig constructor.
     *
     * @param array $viewcounterNode
     */
    public function __construct(array $viewcounterNode)
    {
        $this->viewStrategy = $viewcounterNode['view_strategy'];
    }

    /**
     * Gets the view strategy.
     *
     * @return mixed
     */
    public function getViewStrategy()
    {
        return $this->viewStrategy;
    }

    /**
     * Sets the view strategy.
     *
     * @param $viewStrategy
     *
     * @return $this
     */
    public function setViewStrategy($viewStrategy)
    {
        $this->viewStrategy = $viewStrategy;

        return $this;
    }
}