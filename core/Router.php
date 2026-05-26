<?php
declare(strict_types=1);

class Router
{
    /** @var array<string, array{controller: string, action: string, auth: bool, guest: bool, method: ?string}> */
    private array $routes = [];

    public function register(
        string $page,
        string $controller,
        string $action,
        array $options = []
    ): void {
        $this->routes[$page] = [
            'controller' => $controller,
            'action' => $action,
            'auth' => (bool) ($options['auth'] ?? false),
            'guest' => (bool) ($options['guest'] ?? false),
            'method' => $options['method'] ?? null,
        ];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}|null null when controller exited (redirect)
     */
    public function dispatch(string $page, array $get, array $post): ?array
    {
        if (!isset($this->routes[$page])) {
            return $this->notFound();
        }

        $route = $this->routes[$page];

        if ($route['auth'] && !Session::isLoggedIn()) {
            header('Location: /travelnotes/index.php?page=login');
            exit;
        }

        if ($route['guest'] && Session::isLoggedIn()) {
            header('Location: /travelnotes/index.php?page=view');
            exit;
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($route['method'] !== null && strtoupper($httpMethod) !== strtoupper($route['method'])) {
            return $this->notFound();
        }

        $controllerClass = $route['controller'];
        if (!class_exists($controllerClass)) {
            return $this->notFound();
        }

        $controller = new $controllerClass();
        $action = $route['action'];

        if (!method_exists($controller, $action)) {
            return $this->notFound();
        }

        $result = $controller->{$action}($get, $post);

        if ($result === null) {
            return null;
        }

        if (!is_array($result) || !isset($result['title'], $result['content'])) {
            return $this->notFound();
        }

        return [
            'title' => (string) $result['title'],
            'content' => (string) $result['content'],
        ];
    }

    /**
     * @return array{title: string, content: string}
     */
    private function notFound(): array
    {
        http_response_code(404);

        ob_start();
        $viewPath = BASE_PATH . '/app/Views/errors/404.php';
        if (is_file($viewPath)) {
            require $viewPath;
        } else {
            echo '<div class="error" style="padding:1.5rem;">Страница не найдена</div>';
        }
        $content = (string) ob_get_clean();

        return [
            'title' => 'Страница не найдена',
            'content' => $content,
        ];
    }
}
