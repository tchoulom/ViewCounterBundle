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

namespace Tchoulom\ViewCounterBundle\Statistics;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Hour
 */
class Hour
{
    /**
     * The Hour name.
     *
     * @var string
     */
    protected $name;

    /**
     * The Full Hour.
     *
     * @var false|string
     */
    protected $fullHour;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    use MinuteTrait;

    /**
     * Hour constructor.
     *
     * @param string $name
     * @param int $total
     */
    public function __construct(string $name, int $total)
    {
        $this->name = $name;
        $this->total = $total;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the full hour.
     *
     * @return false|string
     */
    public function getFullHour()
    {
        return $this->fullHour;
    }

    /**
     * Sets the full hour.
     *
     * @param false|string $fullHour
     *
     * @return self
     */
    public function setFullHour($fullHour): self
    {
        $this->fullHour = $fullHour;

        return $this;
    }


    /**
     * Gets the total.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param $total
     *
     * @return self
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Builds the hour.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     */
    public function build(ViewCounterInterface $viewcounter): self
    {
        $this->total++;
        $this->fullHour = Date::getFullHour();

        $minuteName = 'm' . $viewcounter->getViewDate()->format('i');
        $minute = $this->getMinute($minuteName);
        $minuteName = strtolower($minute->getName());
        $this->$minuteName = $minute->build($viewcounter);

        return $this;
    }

    /**
     * Gets the minute.
     *
     * @param string|null $minuteName The minute name.
     *
     * @return Minute                 The minute.
     */
    public function getMinute(string $minuteName = null): Minute
    {
        if (null == $minuteName) {
            $minuteName = 'm' . Date::getMinute();
        }

        $minute = $this->get($minuteName);
        if (!$minute instanceof Minute) {
            $minute = new Minute($minuteName, 0);
        }

        return $minute;
    }
}
