<?php
declare(strict_types=1);

class ContactController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function index(array $get, array $post): array
    {
        $sort = (string) ($get['sort'] ?? 'lastname');
        $pageNum = (int) ($get['p'] ?? 1);
        $limit = 10;

        $userId = (int) Session::user()['id'];

        $contactModel = new Contact();
        $result = $contactModel->getUserContacts($userId, $sort, $pageNum, $limit);

        $content = $this->render('contacts/index', [
            'contacts' => $result['items'],
            'pages' => $result['pages'],
            'current' => $result['current'],
            'sort' => $result['sort'],
            'total' => $result['total'],
        ]);

        return ['title' => 'Мои контакты', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function add(array $get, array $post): array
    {
        $message = '';
        $userId = (int) Session::user()['id'];

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($post['add'])) {
            $contactModel = new Contact();

            $birthdate = !empty($post['birthdate']) ? $post['birthdate'] : null;

            $success = $contactModel->createContact($userId, [
                'lastname' => $post['lastname'] ?? '',
                'firstname' => $post['firstname'] ?? '',
                'middlename' => $post['middlename'] ?? '',
                'gender' => $post['gender'] ?? '',
                'birthdate' => $birthdate,
                'phone' => $post['phone'] ?? '',
                'address' => $post['address'] ?? '',
                'email' => $post['email'] ?? '',
                'comment' => $post['comment'] ?? '',
            ]);

            if ($success) {
                $this->redirect('/travelnotes/index.php?page=view&success=added');
            }

            $message = "<div class='error'>❌ Ошибка добавления</div>";
        }

        $content = $this->render('contacts/add', ['message' => $message]);

        return ['title' => 'Добавление контакта', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function edit(array $get, array $post): array
    {
        $userId = (int) Session::user()['id'];
        $id = (int) ($get['id'] ?? 0);
        $message = '';

        $contactModel = new Contact();
        $contacts = $contactModel->getUserContactsSimple($userId);

        if ($contacts === []) {
            $this->redirect('/travelnotes/index.php?page=add');
        }

        $contactExists = false;
        foreach ($contacts as $c) {
            if ((int) $c['id'] === $id) {
                $contactExists = true;
                break;
            }
        }

        if (!$contactExists) {
            $id = (int) $contacts[0]['id'];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $contact = $stmt->fetch();

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($post['update'])) {
            $birthdate = !empty($post['birthdate']) ? $post['birthdate'] : null;

            $result = $contactModel->updateContact($id, $userId, [
                'lastname' => $post['lastname'] ?? '',
                'firstname' => $post['firstname'] ?? '',
                'middlename' => $post['middlename'] ?? '',
                'gender' => $post['gender'] ?? '',
                'birthdate' => $birthdate,
                'phone' => $post['phone'] ?? '',
                'address' => $post['address'] ?? '',
                'email' => $post['email'] ?? '',
                'comment' => $post['comment'] ?? '',
            ]);

            if ($result) {
                $this->redirect('/travelnotes/index.php?page=view&success=updated');
            }

            $message = "<div class='error'>❌ Ошибка обновления</div>";
            $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE id = ? AND user_id = ?');
            $stmt->execute([$id, $userId]);
            $contact = $stmt->fetch();
        }

        $content = $this->render('contacts/edit', [
            'contact' => $contact,
            'contacts' => $contacts,
            'id' => $id,
            'message' => $message,
        ]);

        return ['title' => 'Редактирование контакта', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     */
    public function delete(array $get, array $post): void
    {
        $id = (int) ($get['delete_id'] ?? 0);
        $userId = (int) Session::user()['id'];

        $contactModel = new Contact();
        $contactModel->deleteContact($id, $userId);

        $this->redirect('/travelnotes/index.php?page=view&success=deleted');
    }
}
