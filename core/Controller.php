<?php
declare(strict_types=1);

class Controller
{
    protected PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        if ($pdo !== null) {
            $this->pdo = $pdo;
        } else {
            $this->pdo = Database::getInstance()->getConnection();
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        $viewPath = BASE_PATH . "/app/Views/{$view}.php";
        if (is_file($viewPath)) {
            require $viewPath;
        } else {
            echo "Шаблон не найден: {$viewPath}";
        }

        return (string) ob_get_clean();
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
