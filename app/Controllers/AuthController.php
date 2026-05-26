<?php
declare(strict_types=1);

class AuthController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function showLogin(array $get = [], array $post = []): array
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/travelnotes/index.php?page=view');
        }

        $error = Session::getFlash('error');
        $success = Session::getFlash('success');

        ob_start();
        ?>
        <div style="max-width: 400px; margin: 2rem auto; padding: 2rem; background: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            <h2 style="color: var(--primary); text-align: center; margin-bottom: 1.5rem;">🔐 Вход в систему</h2>

            <?php if ($error): ?>
                <div class="error" style="margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success" style="margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="/travelnotes/index.php?page=login">
                <div class="form-group">
                    <label class="form-label">Имя пользователя или Email</label>
                    <input type="text" name="username" placeholder="Введите имя пользователя или email" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="password" placeholder="Введите пароль" required>
                </div>
                
                <button type="submit" style="width: 100%;">Войти</button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                Нет аккаунта? <a href="/travelnotes/index.php?page=register" style="color: var(--primary);">Зарегистрироваться</a>
            </p>

            <hr style="margin: 1rem 0; border-color: rgba(67, 97, 238, 0.2);">
            
        </div>
        <?php
        $content = (string) ob_get_clean();

        return ['title' => 'Вход в систему', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     */
    public function login(array $get, array $post): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('/travelnotes/index.php?page=login');
        }

        $username = trim((string) ($post['username'] ?? ''));
        $password = (string) ($post['password'] ?? '');

        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Введите имя пользователя или email';
        }
        
        if (empty($password)) {
            $errors[] = 'Введите пароль';
        }
        
        if (strlen($password) > 0 && strlen($password) < 4) {
            $errors[] = 'Пароль должен быть не менее 4 символов';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirect('/travelnotes/index.php?page=login');
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user) {
            $user = $userModel->findByEmail($username);
        }

        if ($user && Hash::verify($password, $user['password'])) {
            Session::set('user', [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]);
       
            unset($_SESSION['welcome_shown']);
            $this->redirect('/travelnotes/index.php?page=view');
        }

        Session::setFlash('error', 'Неверное имя пользователя или пароль');
        $this->redirect('/travelnotes/index.php?page=login');
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function showRegister(array $get = [], array $post = []): array
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/travelnotes/index.php?page=view');
        }

        $error = Session::getFlash('error');
        $success = Session::getFlash('success');

        ob_start();
        ?>
        <div style="max-width: 500px; margin: 2rem auto; padding: 2rem; background: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            <h2 style="color: var(--primary); text-align: center; margin-bottom: 1.5rem;">📝 Регистрация</h2>

            <?php if ($error): ?>
                <div class="error" style="margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success" style="margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="/travelnotes/index.php?page=register">
                <div class="form-group">
                    <label class="form-label">Имя пользователя *</label>
                    <input type="text" name="username" placeholder="от 3 до 20 символов" required>
                    <small class="form-hint">Только латиница, цифры и подчёркивание</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" placeholder="example@mail.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Пароль *</label>
                    <input type="password" name="password" placeholder="минимум 6 символов" required>
                    <small class="form-hint">Пароль должен содержать минимум 6 символов</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Подтверждение пароля *</label>
                    <input type="password" name="password_confirm" placeholder="Повторите пароль" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">О себе (необязательно)</label>
                    <textarea name="bio" rows="2" placeholder="Расскажите о себе..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Страна (необязательно)</label>
                    <input type="text" name="country" placeholder="Ваша страна">
                </div>
                
                <button type="submit" style="width: 100%;">Зарегистрироваться</button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                Уже есть аккаунт? <a href="/travelnotes/index.php?page=login" style="color: var(--primary);">Войти</a>
            </p>
        </div>
        <?php
        $content = (string) ob_get_clean();

        return ['title' => 'Регистрация', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     */
    public function register(array $get, array $post): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('/travelnotes/index.php?page=register');
        }

        $username = trim((string) ($post['username'] ?? ''));
        $email = trim((string) ($post['email'] ?? ''));
        $password = (string) ($post['password'] ?? '');
        $passwordConfirm = (string) ($post['password_confirm'] ?? '');
        $bio = trim((string) ($post['bio'] ?? ''));
        $country = trim((string) ($post['country'] ?? ''));

        $errors = [];

        if (empty($username)) {
            $errors[] = 'Имя пользователя обязательно для заполнения';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Имя пользователя должно содержать не менее 3 символов';
        } elseif (strlen($username) > 20) {
            $errors[] = 'Имя пользователя не должно превышать 20 символов';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'Имя пользователя может содержать только латинские буквы, цифры и подчёркивание';
        }
        if (empty($email)) {
            $errors[] = 'Email обязателен для заполнения';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Введите корректный email адрес';
        }

        if (empty($password)) {
            $errors[] = 'Пароль обязателен для заполнения';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Пароль должен содержать не менее 6 символов';
        } elseif (strlen($password) > 50) {
            $errors[] = 'Пароль не должен превышать 50 символов';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Пароли не совпадают';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirect('/travelnotes/index.php?page=register');
        }

        $userModel = new User();

        if ($userModel->findByUsername($username)) {
            Session::setFlash('error', 'Пользователь с таким именем уже существует');
            $this->redirect('/travelnotes/index.php?page=register');
        }

        if ($userModel->findByEmail($email)) {
            Session::setFlash('error', 'Пользователь с таким email уже существует');
            $this->redirect('/travelnotes/index.php?page=register');
        }

        $result = $userModel->createUser([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'bio' => $bio,
            'country' => $country,
            'role' => 'user'
        ]);

        if ($result) {
            Session::setFlash('success', 'Регистрация успешна! Теперь вы можете войти в систему');
            $this->redirect('/travelnotes/index.php?page=login');
        } else {
            Session::setFlash('error', 'Ошибка при регистрации. Попробуйте позже');
            $this->redirect('/travelnotes/index.php?page=register');
        }
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     */
    public function logout(array $get, array $post): void
    {
        Session::destroy();
        $this->redirect('/travelnotes/index.php?page=login');
    }
}
?>