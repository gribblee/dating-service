<?php

declare(strict_types=1);

namespace App {
    final class FastLog
    {
        private const int MAX_BUFFER = 100;
        private static mixed $fp = null;
        private static bool $enabled = true;
        private static array $buffer = [];
        private static int $bufferSize = 0;

        public static function init(string $file, bool $enabled = true): void
        {
            self::$enabled = $enabled;
            if ($enabled) {
                self::$fp = fopen($file, 'a');
                register_shutdown_function([self::class, 'flush']);
            }
        }

        public static function info(string $msg, array $ctx = []): void
        {
            self::write('INFO', $msg, $ctx);
        }

        private static function write(string $level, string $msg, array $ctx = []): void
        {
            if (!self::$enabled || !self::$fp) {
                return;
            }

            $ctxDecode =  json_encode($ctx);
            $ctxDecode = false === $ctxDecode ? '' : $ctxDecode;
            // Буферизация для скорости
            self::$buffer[self::$bufferSize++] =
                sprintf("[%s] [%s] %s %s", date('Y-m-d H:i:s'), $level, $msg, $ctxDecode);

            if (self::$bufferSize >= self::MAX_BUFFER) {
                self::flush();
            }
        }

        public static function flush(): void
        {
            if (self::$bufferSize === 0 || !self::$fp) {
                return;
            }

            fwrite(
                self::$fp,
                implode("\n", array_slice(self::$buffer, 0, self::$bufferSize)) . "\n"
            );

            self::$bufferSize = 0;
        }

        public static function error(string $msg, array $ctx = []): void
        {
            self::write('ERROR', $msg, $ctx);
        }

        public static function debug(string $msg, array $ctx = []): void
        {
            if (!empty($_ENV['DEBUG'] ?? '')) {
                if (($_ENV['DEBUG'] ?? 'false') === 'true') {
                    self::write('DEBUG', $msg, $ctx);
                }
            }
        }
    }
}
