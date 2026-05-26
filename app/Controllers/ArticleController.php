<?php
declare(strict_types=1);

class ArticleController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function index(array $get, array $post): array
    {
        $page = (int) ($get['p'] ?? 1);
        $articleModel = new Article();
        $result = $articleModel->getAllWithAuthors($page, 6);

        $content = $this->render('articles/index', [
            'articles' => $result['items'],
            'pages' => $result['pages'],
            'current' => $result['current'],
        ]);

        return ['title' => 'Статьи о путешествиях', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function show(array $get, array $post): array
    {
        $id = (int) ($get['id'] ?? 0);
        $articleModel = new Article();

        $article = $articleModel->getWithAuthor($id);

        if (!$article) {
            return [
                'title' => 'Статья не найдена',
                'content' => '<div class="error" style="padding:1.5rem;">Статья не найдена</div>',
            ];
        }

        $articleModel->incrementViews($id);

        $content = $this->render('articles/show', [
            'article' => $article,
        ]);

        return ['title' => (string) $article['title'], 'content' => $content];
    }
}
