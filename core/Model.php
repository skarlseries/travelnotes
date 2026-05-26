<?php
declare(strict_types=1);

class Model
{
    protected PDO $pdo;
    protected string $table = '';

    public function __construct(?PDO $pdo = null)
    {
        if ($pdo !== null) {
            $this->pdo = $pdo;
        } else {
            $this->pdo = Database::getInstance()->getConnection();
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");

        return $stmt->fetchAll();
    }

    /**
     * @return array<string, mixed>|false
     */
    public function find(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function where(string $column, mixed $value): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);

        return $stmt->fetchAll();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");

        return $stmt->execute([$id]);
    }
}
