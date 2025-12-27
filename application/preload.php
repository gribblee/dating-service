<?php
declare(strict_types=1);

function preloadDirectory(string $dir): void {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->getExtension() === 'php') {
            require_once $file->getPathname();
        }
    }
}

// Подгружаем src/
preloadDirectory(__DIR__ . '/src');
