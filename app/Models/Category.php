<?php
declare(strict_types=1);

class Category extends Model
{
    protected string $table = 'categories';

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll();
    }

    public function getByName(string $name): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function create(string $name, string $slug, ?string $description = null): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $slug, $description]);
    }
}
?>