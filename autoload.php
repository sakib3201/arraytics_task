<?php

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\' => __DIR__ . '/app/',
        'Core\\' => __DIR__ . '/core/',
        'Config\\' => __DIR__ . '/config/',
        'Database\\' => __DIR__ . '/database/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        // Check if class uses the prefix
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Replace namespace separators with directory separators
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Require the file if it exists
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

