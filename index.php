<?php
require_once __DIR__ . '/core/bootstrap.php';

Session::start();

$router = new Router();
$registerRoutes = require __DIR__ . '/config/routes.php';
$registerRoutes($router);

$page = $_GET['page'] ?? 'view';
$sort = $_GET['sort'] ?? 'created_at';

if ($page === 'login' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    (new AuthController())->login($_GET, $_POST);
    exit;
}
if ($page === 'register' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    (new AuthController())->register($_GET, $_POST);
    exit;
}

$result = $router->dispatch($page, $_GET, $_POST);

if ($result === null) {
    exit;
}

$title = $result['title'];
$content = $result['content'];

$menuHtml = '';
if ($page === 'view' && file_exists(__DIR__ . '/app/Views/partials/menu.php')) {
    require_once __DIR__ . '/app/Views/partials/menu.php';
    $menuHtml = renderMenu($page, $sort);
}

require __DIR__ . '/app/Views/layouts/main.php';
?>