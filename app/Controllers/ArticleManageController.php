<?php
declare(strict_types=1);

class ArticleManageController extends Controller
{
    private Article $articleModel;
    private Category $categoryModel;

    public function __construct(?PDO $pdo = null)
    {
        parent::__construct($pdo);
        $this->articleModel = new Article($this->pdo);
        $this->categoryModel = new Category($this->pdo);
    }

    public function myArticles(array $get, array $post): array
    {
        $userId = (int) Session::user()['id'];
        $page = (int) ($get['p'] ?? 1);
        $result = $this->articleModel->getUserArticles($userId, $page);

        $content = $this->render('articles/my_articles', [
            'articles' => $result['items'],
            'pages' => $result['pages'],
            'current' => $result['current'],
            'total' => $result['total']
        ]);

        return ['title' => 'Мои статьи', 'content' => $content];
    }

    public function create(array $get, array $post): array
    {
        $message = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($post['create_article'])) {
            $userId = (int) Session::user()['id'];
            
            $result = $this->articleModel->createArticle($userId, [
                'title' => $post['title'],
                'content' => $post['content'],
                'excerpt' => $post['excerpt'] ?? null,
                'status' => $post['status'] ?? 'published'
            ]);
            
            if ($result) {
                header('Location: /travelnotes/index.php?page=my_articles&success=created');
                exit();
            } else {
                $message = "<div class='error'>❌ Ошибка при создании статьи</div>";
            }
        }
        
        $content = $this->render('articles/create', ['message' => $message]);
        return ['title' => 'Создание статьи', 'content' => $content];
    }

    public function edit(array $get, array $post): array
    {
        $userId = (int) Session::user()['id'];
        $id = (int) ($get['id'] ?? 0);
        
  
        if (!$this->articleModel->isOwner($id, $userId)) {
            header('Location: /travelnotes/index.php?page=my_articles');
            exit();
        }
        
        $article = $this->articleModel->find($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($post['update_article'])) {
            $result = $this->articleModel->updateArticle($id, $userId, [
                'title' => $post['title'],
                'content' => $post['content'],
                'excerpt' => $post['excerpt'] ?? null,
                'status' => $post['status'] ?? 'published'
            ]);
            
            if ($result) {
                header('Location: /travelnotes/index.php?page=my_articles&success=updated');
                exit();
            }
        }
        
        $content = $this->render('articles/edit', [
            'article' => $article,
            'id' => $id
        ]);
        return ['title' => 'Редактирование статьи', 'content' => $content];
    }

    public function delete(array $get, array $post): void
    {
        $userId = (int) Session::user()['id'];
        $id = (int) ($get['id'] ?? 0);
        
        if ($this->articleModel->isOwner($id, $userId)) {
            $this->articleModel->deleteArticle($id, $userId);
        }
        
        header('Location: /travelnotes/index.php?page=my_articles&success=deleted');
        exit();
    }
}
?>