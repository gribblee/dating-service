<?php

declare(strict_types=1);

namespace App;

final class FastLog
{
    private const int MAX_BUFFER = 100;
    private mixed $fp = null;
    private bool $enabled = true;
    private array $buffer = [];
    private int $bufferSize = 0;

    public function __construct(string $file, bool $enabled = true)
    {
        $this->enabled = $enabled;
        if ($enabled) {
            $this->fp = fopen($file, 'a');
        }
    }

    public function __destruct()
    {
        if ($this->enabled) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        if ($this->bufferSize === 0 || !$this->fp) {
            return;
        }

        fwrite(
            $this->fp,
            implode("\n", array_slice($this->buffer, 0, $this->bufferSize)) . "\n"
        );

        $this->bufferSize = 0;
    }

    public function info(string $msg, array $ctx = []): void
    {
        $this->write('INFO', $msg, $ctx);
    }

    private function write(string $level, string $msg, array $ctx = []): void
    {
        if (!$this->enabled || !$this->fp) {
            return;
        }

        $ctxDecode = json_encode($ctx);
        $ctxDecode = false === $ctxDecode ? '' : $ctxDecode;
        // Буферизация для скорости
        $this->buffer[$this->bufferSize++] =
            sprintf("[%s] [%s] %s %s", date('Y-m-d H:i:s'), $level, $msg, $ctxDecode);

        if ($this->bufferSize >= self::MAX_BUFFER) {
            $this->flush();
        }
    }

    public function error(string $msg, array $ctx = []): void
    {
        $this->write('ERROR', $msg, $ctx);
    }

    public function debug(string $msg, array $ctx = []): void
    {
        if (!empty($_ENV['DEBUG'] ?? '')) {
            if (($_ENV['DEBUG'] ?? 'false') === 'true') {
                $this->write('DEBUG', $msg, $ctx);
            }
        }
    }
}
