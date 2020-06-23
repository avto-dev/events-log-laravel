<?php

declare(strict_types = 1);

namespace AvtoDev\EventsLogLaravel\Logging\Handlers;

use Throwable;
use Monolog\Logger;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Monolog\Handler\AbstractProcessingHandler;

class UdpHandler extends AbstractProcessingHandler
{
    /**
     * @var UdpSocket
     */
    protected $socket;

    /**
     * @var bool
     */
    protected $silent;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * UdpHandler constructor.
     *
     * @param string $host
     * @param int    $port
     * @param int    $level  The minimum logging level at which this handler will be triggered
     * @param bool   $bubble Whether the messages that are handled can bubble up the stack or not
     * @param bool   $silent Do NOT throws exceptions on socket errors
     */
    public function __construct(string $host,
                                int $port,
                                int $level = Logger::DEBUG,
                                bool $bubble = true,
                                bool $silent = true)
    {
        $this->silent = $silent;
        $this->host   = $host;
        $this->port   = $port;

        parent::__construct($level, $bubble);

        $this->socket = new UdpSocket($host, $port);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return bool
     */
    public function isSilent(): bool
    {
        return $this->silent;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Throwable
     */
    public function close(): void
    {
        try {
            $this->socket->close();
        } catch (Throwable $e) {
            if ($this->silent === false) {
                throw $e;
            }
        }
    }

    /**
     * Convert record into string.
     *
     * @param array<string, mixed> $record
     *
     * @return string
     */
    public function recordToString(array $record): string
    {
        if (isset($record['formatted']) && \is_string($formatted = $record['formatted'])) {
            return $formatted;
        }

        return 'ERROR: FORMATTER NOT SET';
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param array<string, mixed> $record
     *
     * @throws Throwable
     *
     * @return void
     */
    protected function write(array $record): void
    {
        try {
            $this->socket->write($this->recordToString($record));
        } catch (Throwable $e) {
            if ($this->silent === false) {
                throw $e;
            }
        }
    }
}
