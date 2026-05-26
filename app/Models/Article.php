<?php
declare(strict_types=1);

class Article extends Model
{
    protected string $table = 'articles';

    public function getWithAuthor(int $id): array|false
    {
        $stmt = $this->pdo->prepare("
            SELECT a.*, u.username as author_name, u.id as author_id
            FROM articles a
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllWithAuthors(int $page = 1, int $limit = 6): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("
            SELECT a.*, u.username as author_name
            FROM articles a
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.status = 'published' OR a.status IS NULL
            ORDER BY a.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        $total = (int) $this->pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'published' OR status IS NULL")->fetchColumn();
        $pages = (int) ceil($total / $limit);

        return ['items' => $items, 'total' => $total, 'pages' => $pages, 'current' => $page];
    }

    public function getUserArticles(int $userId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("
            SELECT * FROM articles 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        $totalStmt = $this->pdo->prepare("SELECT COUNT(*) FROM articles WHERE user_id = ?");
        $totalStmt->execute([$userId]);
        $total = (int) $totalStmt->fetchColumn();
        $pages = (int) ceil($total / $limit);

        return [
            'items' => $items, 
            'total' => $total, 
            'pages' => $pages, 
            'current' => $page
        ];
    }

    public function createArticle(int $userId, array $data): bool|int
    {
        $slug = $this->generateSlug($data['title']);
        $sql = "INSERT INTO articles (title, slug, content, excerpt, author_id, user_id, status, views) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            $data['title'],
            $slug,
            $data['content'],
            $data['excerpt'] ?? null,
            $userId,
            $userId,
            $data['status'] ?? 'published',
            0
        ]);
        
        return $result ? (int) $this->pdo->lastInsertId() : false;
    }

    public function updateArticle(int $id, int $userId, array $data): bool
    {
        $slug = $this->generateSlug($data['title'], $id);
        $sql = "UPDATE articles SET title = ?, slug = ?, content = ?, excerpt = ?, status = ? 
                WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['title'],
            $slug,
            $data['content'],
            $data['excerpt'] ?? null,
            $data['status'] ?? 'published',
            $id,
            $userId
        ]);
    }

    public function deleteArticle(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM articles WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    public function isOwner(int $articleId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM articles WHERE id = ? AND user_id = ?");
        $stmt->execute([$articleId, $userId]);
        return (bool) $stmt->fetch();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }

    private function generateSlug(string $title, ?int $excludeId = null): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9-]+/', '-', $title), '-'));
        $slug = substr($slug, 0, 100);
        
        $stmt = $this->pdo->prepare("SELECT id FROM articles WHERE slug = ? AND id != ?");
        $stmt->execute([$slug, $excludeId ?? 0]);
        if ($stmt->fetch()) {
            return $slug . '-' . time();
        }
        return $slug;
    }
}
?>