<?php namespace BW;
/**
 * Dependency injection container configuration
 */

use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;
use Slim\Container;


$settings = require __DIR__ . '/../config/settings.php';
$container = new Container($settings);

/**
 * File upload handler
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \Sirius\Upload\Handler
 */
$container['fileUpload'] = function ($c) {
    $uploadHandler = new \Sirius\Upload\Handler($c->get('settings')['imageDir']);

    // validation rules
    $uploadHandler->addRule(
        'extension',
        ['allowed' => ['jpg', 'png']],
        '{label} should be a valid image (jpg, png)',
        'Book Cover'
    );

    $uploadHandler->addRule('size', ['max' => '1M'], '{label} should have less than {max}', 'Book Cover');

    $uploadHandler->setSanitizerCallback(function ($name) {
        return \preg_replace('/[^a-zA-Z0-9._\-]+/', '_', $name);
    });

    return $uploadHandler;
};

/**
 * Handles processing of forms.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \${namespace}\Forms\FormHandler
 */
$container['formService'] = function ($c) {
    return new \${namespace}\Forms\FormHandler('formName');
};

/**
 * Respond to HTML page request.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \${namespace}\Controllers\Html
 */
$container['htmlController'] = function ($c) {
    return new \${namespace}\Controllers\Html(
        $c->get('request'),
        $c->get('response'),
        $c->get('formService')
    );
};

/**
 * Logging
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \Monolog\Logger
 */
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);

    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

/**
 * Render templates.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \Whip\Renderer
 */
$container['renderer'] = function ($c) {
    $settings = $c->get('settings');
    $templateDir = $settings['renderer']['template_path'];
    $fileLoader = new \Twig_Loader_Filesystem($templateDir);

    $twig = new \Twig_Environment(
        $fileLoader,
        [
            'strict_variables' => true,
            'autoescape' => false
        ]
    );

    $renderer = new \Whip\TwigRenderer($twig);

    $renderer->addData(['imageDir' => '/images']);

    return $renderer;
};

return $container;