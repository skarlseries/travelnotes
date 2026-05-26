<?php
declare(strict_types=1);

class UserController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function profile(array $get, array $post): array
    {
        $userModel = new User();
        $userId = (int) Session::user()['id'];

        $user = $userModel->find($userId);
        $contacts = $userModel->getContacts($userId);
        $trips = $userModel->getTrips($userId);
        $articles = $userModel->getArticles($userId);

        $content = $this->render('profile/index', [
            'user' => $user,
            'contacts' => $contacts,
            'trips' => $trips,
            'articles' => $articles,
        ]);

        return ['title' => 'Мой профиль', 'content' => $content];
    }
}
