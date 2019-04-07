<?php namespace ${namespace};
/**
 * Dependency injection container configuration
 */

use Interop\Container\ContainerInterface;
use Slim\Container;

const IS_PROD = false;

$settings = require __DIR__ . '/../config/settings.php';
$container = new Container($settings);
unset($settings);

/**
 * Form storage.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \Whip\FormFactory
 */
$container['formFactory'] = function (ContainerInterface $c) {
    $validator = new \Whip\Lash\Validation();
    $books = $c->get('books');
    $session = $c->get('session');
    $formFactory = new \Whip\FormFactory();


    $formFactory->set(
        ${namespace}\Forms\Login::class,
        function () use ($books, $validator, $session) {
            $login = new ${namespace}\Forms\Login(
                $validator,
                $books
            );

            $login->withSession($session);

            return $login;
        }
    );

    return $formFactory;
};

/**
 * Handles processing of forms.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return ${namespace}\Forms\FormHandler
 */
$container['formService'] = function ($c) {
    $formController =  new ${namespace}\Forms\FormHandler(
        $c->get('request'),
        $c->get('response'),
        'formName',
        $c->get('formFactory'),
        $c->get('session')
    );

    return $formController;
};

/**
 * Respond to HTML page request.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return ${namespace}\Controllers\Html
 */
$container['htmlController'] = function ($c) {
    $htmlController= new ${namespace}\Controllers\Html(
        $c->get('request'),
        $c->get('response'),
        $c->get('formService')
    );

    $htmlController->withSession($c->get('session'));

    return $htmlController;
};

/**
 * Logging
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return \Monolog\Logger
 */
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\LoggerLogger($settings['name']);

    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

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

    $renderer->addData([
        'imageDir' => '/images',
        'min' => IS_PROD ? '.min' : '',
    ]);

    return $renderer;
};

/**
 * Get session handler.
 *
 * @return ${namespace}\WorkSession
 */
$container['session'] = function () {
    return new ${namespace}\WorkSession();
};

/**
 * Returns a validator.
 *
 * @return \Whip\Lash\Validation
 */
$container['validator'] = function () {
    return new \Whip\Lash\Validation();
};

/**
 * Get works for an account.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return array
 */
$container['work'] = function (ContainerInterface $c) {
    $db = $c->get('books');
    $workId = \filter_input(
        INPUT_GET,
        'workId',
        FILTER_SANITIZE_STRING,
        ['flags' => FILTER_SANITIZE_URL]
    );

    if (!empty($workId)) {
        $session = $c->get('session');
        $session->setCurrentWork($workId);
    }

    return $db->getWork($workId);
};

/**
 * Get works for an account.
 *
 * @param \Interop\Container\ContainerInterface $c
 * @return array
 */
$container['works'] = function (ContainerInterface $c) {
    $db = $c->get('books');

    return $db->getWorks();
};

return $container;