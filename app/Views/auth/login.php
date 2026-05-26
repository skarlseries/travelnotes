<div style="max-width: 400px; margin: 2rem auto; padding: 2rem; background: var(--bg-card); border-radius: 24px;">
    <h2 style="color: var(--accent-gold); text-align: center;">🔐 Вход в систему</h2>
    
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
    
    <form method="POST" action="/travelnotes/index.php?page=login">
        <input type="text" name="username" placeholder="Имя пользователя или Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" style="width: 100%;">Войти</button>
    </form>
    
    <p style="text-align: center; margin-top: 1rem; color: var(--text-muted);">
        Нет аккаунта? <a href="/travelnotes/index.php?page=register" style="color: var(--accent-gold);">Зарегистрироваться</a>
    </p>
    
    <hr style="margin: 1rem 0; border-color: rgba(212, 175, 55, 0.2);">
    
</div>