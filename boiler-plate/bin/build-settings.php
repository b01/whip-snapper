<?php namespace BW;

echo PHP_EOL . PHP_EOL . 'Building the settings file...';

    // Try to detect which environment we are running in.
    $env = array_key_exists('APP_ENV', $_SERVER) ? $_SERVER['APP_ENV'] : 'development';

    $envSettingsFile = $env . '-settings.php';

    $settingsFile = APP_ROOT . DIRECTORY_SEPARATOR . 'config'
        . DIRECTORY_SEPARATOR . 'settings.php';

    $configDir = APP_ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'env';

    if (!\is_dir($configDir)) {
        exit(
            PHP_EOL . PHP_EOL
            . 'Unable to build the setting file; and also the configuration directory does not exists: '
            . $configDir
            . PHP_EOL . PHP_EOL
        );
    }

    if (!\file_exists($configDir . DIRECTORY_SEPARATOR . $envSettingsFile)) {
        exit(
            PHP_EOL . PHP_EOL
            . 'Unable to build the settings file because the file '
            . $envSettingsFile
            . ' does not exist.'
            . PHP_EOL . PHP_EOL
        );
    }

    $settingsPhp = include $configDir . DIRECTORY_SEPARATOR . $envSettingsFile;
    $output = '<?php' . PHP_EOL . 'return ' . var_export($settingsPhp, true) . ';';

    // Save the rendered settings file.
    \file_put_contents($settingsFile, $output);

    echo ' is done' . PHP_EOL . PHP_EOL;