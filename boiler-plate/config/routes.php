<?php namespace BW;
/**
 * Routes
 */
use Psr\Http\Message\ServerRequestInterface;
const REDIRECT_DEFAULT = '/';

$app->any('/', function () {
    $view = new ${namespace}\Views\Login($this->renderer);

    return $this->htmlController
        ->addForm($this->formLogin)
        ->render($view);
});

$app->any('/add-account.html', function () {
    $view = new ${namespace}\Views\AddAccount($this->renderer);

    return $this->htmlController
        ->addForm($this->formAccountAdd)
        ->render($view);
});

$app->any('/edit-account.html', function () {
    $view = new ${namespace}\Views\EditAccount($this->renderer);

    $this->htmlController->requiresLoginFrom(REDIRECT_DEFAULT);

    return $this->htmlController
        ->addForm($this->formAccountEdit)
        ->render($view);
});

$app->get('/edit-work.html', function () {
    $view = new ${namespace}\Views\EditWork($this->renderer);

    $this->htmlController->requiresLoginFrom(REDIRECT_DEFAULT);

    return $this->htmlController
        ->addForm($this->formWorkEdit)
        ->render($view);
});

$app->any('/start.html', function () {
    $view = new ${namespace}\Views\Start($this->renderer);

    return $this->htmlController
        ->addForm($this->formLogin)
        ->render($view);
});

$app->post('/new-book.html', function (ServerRequestInterface $request) {
    $uri = $request->getUri();
    $uri->withScheme('https')
        ->withPath('/start.html');

    return $this->htmlController
        ->addForm($this->formWorkNew)
        ->redirectTo($uri, 307);
});