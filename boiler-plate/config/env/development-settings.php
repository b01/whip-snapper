<?php

require_once __DIR__
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'vendor'
    . DIRECTORY_SEPARATOR . 'autoload.php';

$appRoot = realpath(__DIR__
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . '..'
);

return [
  'settings' => [
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
    'renderer' => [
      'template_path' =>$appRoot . '/templates/'
    ],
    'logger' => [
      'name' => '${namespace}',
      'path' => $appRoot . '/logs/app.log',
      'level' => \Monolog\Logger::DEBUG
    ],
    'imageDir' => $appRoot . '/web-ui/images',
    'cacheDir' => $appRoot . '/cache'
  ]
];