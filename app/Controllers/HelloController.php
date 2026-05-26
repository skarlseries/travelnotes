<?php
declare(strict_types=1);

class HelloController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function hello(array $get, array $post): array
    {
        $name = trim((string) ($get['name'] ?? ''));
        
        if (empty($name) && Session::isLoggedIn()) {
            $name = Session::user()['username'];
        }
        
        if (empty($name)) {
            $name = 'Гость';
        }
        
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        
        $content = $this->render('pages/hello', ['name' => $name]);
        
        return ['title' => 'Страница приветствия', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function bye(array $get, array $post): array
    {
        $name = trim((string) ($get['name'] ?? ''));
        
        if (empty($name) && Session::isLoggedIn()) {
            $name = Session::user()['username'];
        }
        
        if (empty($name)) {
            $name = 'Гость';
        }
        
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        
        $content = $this->render('pages/bye', ['name' => $name]);
        
        return ['title' => 'Страница прощания', 'content' => $content];
    }
}
?>