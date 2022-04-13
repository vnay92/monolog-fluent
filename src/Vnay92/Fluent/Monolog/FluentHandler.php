<?php

/*
 * This file is part of the monolog-fluent package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vnay92\Fluent\Monolog;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

use Fluent\Logger\FluentLogger;

/**
 * Simple Monolog handler for the Fluent event collector system.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 * @link http://fluentd.org
 */
class FluentHandler extends AbstractProcessingHandler
{
    protected $parameters;
    protected $logger;

    /**
     * Initialize Handler
     *
     * @param FluentLogger $logger
     * @param bool|string $host
     * @param int $port
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(
        $logger = null,
        $host   = FluentLogger::DEFAULT_ADDRESS,
        $port   = FluentLogger::DEFAULT_LISTEN_PORT,
        $level  = Logger::DEBUG,
        $bubble = true
    ) {
        parent::__construct($level, $bubble);

        if (is_null($logger)) {
            $logger = new FluentLogger($host, $port);
        }

        var_dump($logger);

        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function write(array $record): void
    {
        $record['level'] = Logger::getLevelName($record['level']);
        $tag  = $record['channel'] . '.' . $record['message'];
        $this->logger->post($tag, $record);
    }
}
