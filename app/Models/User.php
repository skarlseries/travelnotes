<?php
declare(strict_types=1);

class User extends Model
{
    protected string $table = 'users';

    /**
     * @return array<string, mixed>|false
     */
    public function firstWhere(string $column, mixed $value): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    /**
     * @return array<string, mixed>|false
     */
    public function findByUsername(string $username): array|false
    {
        return $this->firstWhere('username', $username);
    }

    /**
     * @return array<string, mixed>|false
     */
    public function findByEmail(string $email): array|false
    {
        return $this->firstWhere('email', $email);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createUser(array $data): bool
    {
        $sql = 'INSERT INTO users (username, email, password, bio, country, role) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password'],
            $data['bio'] ?? null,
            $data['country'] ?? null,
            $data['role'] ?? 'user',
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateProfile(int $id, array $data): bool
    {
        $sql = 'UPDATE users SET bio = ?, country = ? WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['bio'], $data['country'], $id]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getContacts(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE user_id = ? ORDER BY lastname, firstname');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getTrips(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM trips WHERE user_id = ? ORDER BY start_date DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getArticles(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE author_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}