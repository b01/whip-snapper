#! /usr/bin/env php
<?php namespace ${namespace};

define(
    '${namespace}\\APP_ROOT',
    realpath(__DIR__ . DIRECTORY_SEPARATOR . '..')
);

// Set the current working directory to the application root.
chdir(APP_ROOT);

// Display which directory this script is working in.
echo 'Current working directory: ' . getcwd() . \PHP_EOL;

echo 'Download PHP dependencies...' . PHP_EOL;
    $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    $composerCmd = $isWindows ? 'composer update' : 'composer.phar update';
    \passthru($composerCmd);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'build-settings.php';

echo 'Get CSS & JS dependencies...' . PHP_EOL;
    \passthru('npm run build');
