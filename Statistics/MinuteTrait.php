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

/**
 * Trait MinuteTrait
 */
trait MinuteTrait
{
    protected $m00;
    protected $m01;
    protected $m02;
    protected $m03;
    protected $m04;
    protected $m05;
    protected $m06;
    protected $m07;
    protected $m08;
    protected $m09;
    protected $m10;
    protected $m11;
    protected $m12;
    protected $m13;
    protected $m14;
    protected $m15;
    protected $m16;
    protected $m17;
    protected $m18;
    protected $m19;
    protected $m20;
    protected $m21;
    protected $m22;
    protected $m23;
    protected $m24;
    protected $m25;
    protected $m26;
    protected $m27;
    protected $m28;
    protected $m29;
    protected $m30;
    protected $m31;
    protected $m32;
    protected $m33;
    protected $m34;
    protected $m35;
    protected $m36;
    protected $m37;
    protected $m38;
    protected $m39;
    protected $m40;
    protected $m41;
    protected $m42;
    protected $m43;
    protected $m44;
    protected $m45;
    protected $m46;
    protected $m47;
    protected $m48;
    protected $m49;
    protected $m50;
    protected $m51;
    protected $m52;
    protected $m53;
    protected $m54;
    protected $m55;
    protected $m56;
    protected $m57;
    protected $m58;
    protected $m59;

    /**
     * Gets the minute.
     *
     * @param string $minuteName The minute name.
     *
     * @return Minute|null       The minute.
     */
    public function get(string $minuteName): ?Minute
    {
        return $this->$minuteName;
    }
}
