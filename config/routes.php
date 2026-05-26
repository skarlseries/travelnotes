<?php
declare(strict_types=1);

return static function (Router $router): void {
    $router->register('view', 'ContactController', 'index', ['auth' => true]);
    $router->register('add', 'ContactController', 'add', ['auth' => true]);
    $router->register('edit', 'ContactController', 'edit', ['auth' => true]);
    $router->register('delete', 'ContactController', 'delete', ['auth' => true]);

    $router->register('profile', 'UserController', 'profile', ['auth' => true]);

    $router->register('articles', 'ArticleController', 'index');
    $router->register('article', 'ArticleController', 'show');

    $router->register('about', 'PageController', 'about');
    $router->register('feedback', 'PageController', 'feedback');
    $router->register('headers', 'PageController', 'headers');

    $router->register('hello', 'HelloController', 'hello');
    $router->register('bye', 'HelloController', 'bye');

    $router->register('login', 'AuthController', 'showLogin', ['guest' => true]);
    $router->register('register', 'AuthController', 'showRegister', ['guest' => true]);
    $router->register('logout', 'AuthController', 'logout');

    $router->register('my_articles', 'ArticleManageController', 'myArticles', ['auth' => true]);
    $router->register('article_create', 'ArticleManageController', 'create', ['auth' => true]);
    $router->register('article_edit', 'ArticleManageController', 'edit', ['auth' => true]);
    $router->register('article_delete', 'ArticleManageController', 'delete', ['auth' => true]);
};