<?php
declare(strict_types=1);

class Contact extends Model
{
    protected string $table = 'contacts';  

    private const SORT_COLUMNS = [
        'lastname' => 'lastname',
        'firstname' => 'firstname',
        'birthdate' => 'birthdate',
        'created_at' => 'created_at',
    ];

    /**
     * @return array{items: array, total: int, pages: int, current: int, sort: string}
     */
    public function getUserContacts(int $userId, string $sort = 'lastname', int $page = 1, int $limit = 10): array
    {
        $sortKey = array_key_exists($sort, self::SORT_COLUMNS) ? $sort : 'lastname';
        $sortColumn = self::SORT_COLUMNS[$sortKey];

        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM contacts WHERE user_id = ? ORDER BY {$sortColumn} ASC LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        $items = $stmt->fetchAll();

        $countStmt = $this->pdo->prepare('SELECT COUNT(*) FROM contacts WHERE user_id = ?');
        $countStmt->execute([$userId]);
        $total = (int) $countStmt->fetchColumn();
        $pages = (int) ceil($total / $limit);

        return [
            'items' => $items,
            'total' => $total,
            'pages' => $pages,
            'current' => $page,
            'sort' => $sortKey,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUserContactsSimple(int $userId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT id, lastname, firstname, middlename
            FROM contacts
            WHERE user_id = ?
            ORDER BY lastname, firstname
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createContact(int $userId, array $data): bool
    {
        $sql = 'INSERT INTO contacts (user_id, lastname, firstname, middlename, gender, birthdate, phone, address, email, comment)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $userId,
            $data['lastname'],
            $data['firstname'],
            $data['middlename'],
            $data['gender'],
            $data['birthdate'],
            $data['phone'],
            $data['address'],
            $data['email'],
            $data['comment'],
        ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateContact(int $id, int $userId, array $data): bool
    {
        $sql = 'UPDATE contacts SET lastname=?, firstname=?, middlename=?, gender=?, birthdate=?, phone=?, address=?, email=?, comment=?
                WHERE id=? AND user_id=?';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['lastname'],
            $data['firstname'],
            $data['middlename'],
            $data['gender'],
            $data['birthdate'],
            $data['phone'],
            $data['address'],
            $data['email'],
            $data['comment'],
            $id,
            $userId,
        ]);
    }

    public function deleteContact(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE id = ? AND user_id = ?');
        return $stmt->execute([$id, $userId]);
    }
}