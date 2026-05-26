<div style="max-width: 500px; margin: 2rem auto; padding: 2rem; background: var(--bg-card); border-radius: 24px;">
    <h2 style="color: var(--accent-gold); text-align: center;">📝 Регистрация</h2>
    
    <?php if (isset($error) && $error): ?>
        <div class="error" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; padding: 0.75rem; border-radius: 12px; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($success) && $success): ?>
        <div class="success" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; padding: 0.75rem; border-radius: 12px; margin-bottom: 1rem;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/travelnotes/index.php?page=register">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль (мин. 6 символов)" required>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
        <button type="submit" style="width: 100%;">Зарегистрироваться</button>
    </form>
    
    <p style="text-align: center; margin-top: 1rem; color: var(--text-muted);">
        Уже есть аккаунт? <a href="/travelnotes/index.php?page=login" style="color: var(--accent-gold);">Войти</a>
    </p>
</div>