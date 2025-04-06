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

namespace Tchoulom\ViewCounterBundle\Exception;

/**
 * Class IOException
 */
class IOException extends RuntimeException implements IOExceptionInterface
{
    /**
     * The path
     */
    private $path;

    /**
     * IOException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     * @param null $path
     */
    public function __construct($message, $code = 0, ?\Exception $previous = null, $path = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }
}
