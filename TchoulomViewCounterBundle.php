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

namespace Tchoulom\ViewCounterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TchoulomViewCounterBundle extends Bundle
{
    /**
     * The supported view interval.
     *
     * @var array
     */
    const SUPPORTED_INTERVAL = ['unique_view', 'daily_view', 'hourly_view', 'weekly_view', 'monthly_view'];
}
