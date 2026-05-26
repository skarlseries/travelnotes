<?php
require_once __DIR__ . '/../../../core/Session.php';
Session::start();

$currentPage = $_GET['page'] ?? 'view';

$showWelcome = false;
if (Session::isLoggedIn() && !isset($_SESSION['welcome_shown'])) {
    $showWelcome = true;
    $_SESSION['welcome_shown'] = true;
}

$username = Session::isLoggedIn() ? Session::user()['username'] : 'Гость';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <title><?= htmlspecialchars($title ?? 'TravelNotes') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/travelnotes/public/style/style.css">
</head>
<body>

<?php if ($showWelcome): ?>
<div id="welcomeToast" class="toast-notification success">
    👋 Добро пожаловать, <strong><?= htmlspecialchars($username) ?></strong>!
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('welcomeToast');
        if (toast) toast.remove();
    }, 4000);
</script>
<?php endif; ?>

<header>
    <div class="header-container">
        <div class="logo">
            <img src="/public/images/logo_mospolytech.tif" alt="Московский политех">
            <span>TravelNotes</span>
        </div>
        
        <div class="header-right">
            <?php if (Session::isLoggedIn()): ?>
                <div class="user-menu desktop-only">
                    <span class="user-name">👤 <?= htmlspecialchars($username) ?></span>
                    <a href="/travelnotes/index.php?page=logout" class="btn-logout" id="logoutBtn">🚪 Выйти</a>
                </div>
            <?php else: ?>
                <div class="auth-buttons desktop-only">
                    <a href="/travelnotes/index.php?page=login" class="btn-login">🔐 Вход</a>
                    <a href="/travelnotes/index.php?page=register" class="btn-register">📝 Регистрация</a>
                </div>
            <?php endif; ?>
            
            <button id="themeToggle" class="theme-toggle" aria-label="Переключить тему">🌙</button>
            <button class="burger-btn" id="burgerBtn" aria-label="Меню">☰</button>
        </div>
    </div>
    
    <nav class="desktop-nav">
        <?php if (Session::isLoggedIn()): ?>
            <div class="nav-group">
                <span class="nav-group-title">📇 ЗАПИСНАЯ КНИЖКА</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=view" class="<?= $currentPage == 'view' ? 'active' : '' ?>">📋 Просмотр</a>
                    <a href="/travelnotes/index.php?page=add" class="<?= $currentPage == 'add' ? 'active' : '' ?>">➕ Добавить</a>
                </div>
            </div>
            <div class="nav-group">
                <span class="nav-group-title">📖 КОНТЕНТ</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=articles" class="<?= $currentPage == 'articles' ? 'active' : '' ?>">📰 Статьи</a>
                    <a href="/travelnotes/index.php?page=my_articles" class="<?= $currentPage == 'my_articles' ? 'active' : '' ?>">✍️ Мои статьи</a>
                    <a href="/travelnotes/index.php?page=profile" class="<?= $currentPage == 'profile' ? 'active' : '' ?>">👤 Профиль</a>
                </div>
            </div>
            <div class="nav-group">
                <span class="nav-group-title">ℹ️ ИНФОРМАЦИЯ</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=about" class="<?= $currentPage == 'about' ? 'active' : '' ?>">📖 О проекте</a>
                    <a href="/travelnotes/index.php?page=feedback" class="<?= $currentPage == 'feedback' ? 'active' : '' ?>">📧 Обратная связь</a>
                    <a href="/travelnotes/index.php?page=headers" class="<?= $currentPage == 'headers' ? 'active' : '' ?>">📡 HTTP Headers</a>
                </div>
            </div>
            <div class="nav-group">
                <span class="nav-group-title">🎭 ДЕМО</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=hello&name=<?= urlencode($username) ?>" class="<?= $currentPage == 'hello' ? 'active' : '' ?>">👋 Приветствие</a>
                    <a href="/travelnotes/index.php?page=bye&name=<?= urlencode($username) ?>" class="<?= $currentPage == 'bye' ? 'active' : '' ?>">👋 Прощание</a>
                </div>
            </div>
        <?php else: ?>
            <div class="nav-group">
                <span class="nav-group-title">📖 КОНТЕНТ</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=articles" class="<?= $currentPage == 'articles' ? 'active' : '' ?>">📰 Статьи</a>
                </div>
            </div>
            <div class="nav-group">
                <span class="nav-group-title">ℹ️ ИНФОРМАЦИЯ</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=about" class="<?= $currentPage == 'about' ? 'active' : '' ?>">📖 О проекте</a>
                    <a href="/travelnotes/index.php?page=feedback" class="<?= $currentPage == 'feedback' ? 'active' : '' ?>">📧 Обратная связь</a>
                    <a href="/travelnotes/index.php?page=headers" class="<?= $currentPage == 'headers' ? 'active' : '' ?>">📡 HTTP Headers</a>
                </div>
            </div>
            <div class="nav-group">
                <span class="nav-group-title">🎭 ДЕМО</span>
                <div class="nav-links">
                    <a href="/travelnotes/index.php?page=hello&name=Гость" class="<?= $currentPage == 'hello' ? 'active' : '' ?>">👋 Приветствие</a>
                    <a href="/travelnotes/index.php?page=bye&name=Гость" class="<?= $currentPage == 'bye' ? 'active' : '' ?>">👋 Прощание</a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
</header>

<!-- Мобильное меню (overlay) -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay">
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <div class="logo">
                <img src="/travelnotes/public/images/logo.png" alt="TravelNotes">
                <span>TravelNotes</span>
            </div>
            <button class="mobile-menu-close" id="closeMobileMenu">✕</button>
        </div>
        
        <div class="mobile-menu-content">
            <?php if (Session::isLoggedIn()): ?>
                <div class="mobile-user-info">
                    <div class="mobile-user-name">👤 <?= htmlspecialchars($username) ?></div>
                    <a href="/travelnotes/index.php?page=logout" class="btn-logout" id="mobileLogoutBtn">🚪 Выйти</a>
                </div>
            <?php endif; ?>
            
            <div class="mobile-nav-group">
                <div class="mobile-nav-group-title">📇 ЗАПИСНАЯ КНИЖКА</div>
                <a href="/travelnotes/index.php?page=view">📋 Просмотр</a>
                <a href="/travelnotes/index.php?page=add">➕ Добавить</a>
                <a href="/travelnotes/index.php?page=edit">✏️ Редактировать</a>
                <a href="/travelnotes/index.php?page=delete">🗑️ Удалить</a>
            </div>
            
            <div class="mobile-nav-group">
                <div class="mobile-nav-group-title">📖 КОНТЕНТ</div>
                <a href="/travelnotes/index.php?page=articles">📰 Статьи</a>
                <?php if (Session::isLoggedIn()): ?>
                <a href="/travelnotes/index.php?page=my_articles">✍️ Мои статьи</a>
                <a href="/travelnotes/index.php?page=profile">👤 Профиль</a>
                <?php endif; ?>
            </div>
            
            <div class="mobile-nav-group">
                <div class="mobile-nav-group-title">ℹ️ ИНФОРМАЦИЯ</div>
                <a href="/travelnotes/index.php?page=about">📖 О проекте</a>
                <a href="/travelnotes/index.php?page=feedback">📧 Обратная связь</a>
                <a href="/travelnotes/index.php?page=headers">📡 HTTP Headers</a>
            </div>
            
            <div class="mobile-nav-group">
                <div class="mobile-nav-group-title">🎭 ДЕМО</div>
                <a href="/travelnotes/index.php?page=hello&name=<?= urlencode($username) ?>">👋 Приветствие</a>
                <a href="/travelnotes/index.php?page=bye&name=<?= urlencode($username) ?>">👋 Прощание</a>
            </div>
            
            <?php if (!Session::isLoggedIn()): ?>
            <div class="mobile-auth-buttons">
                <a href="/travelnotes/index.php?page=login" class="btn-login">🔐 Вход</a>
                <a href="/travelnotes/index.php?page=register" class="btn-register">📝 Регистрация</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<main class="container">
    <?php if ($currentPage == 'view' || $currentPage == 'hello' || $currentPage == 'bye'): ?>
    <div class="breadcrumb">
        <a href="/travelnotes/index.php">🏠 Главная</a> / 
        <span>
            <?php if ($currentPage == 'view'): ?>Контакты
            <?php elseif ($currentPage == 'hello'): ?>Приветствие
            <?php else: ?>Прощание
            <?php endif; ?>
        </span>
    </div>
    <?php endif; ?>
    <?= $menuHtml ?? '' ?>
    <?= $content ?? '' ?>
</main>

<footer>
    <div class="footer-content">
        <p>🌍 TravelNotes — веб-сервис для путешественников</p>
        <p>© <?= date('Y') ?> Все права защищены</p>
        <?php if (Session::isLoggedIn()): ?>
            <p class="user-status">✅ Вы вошли как <strong><?= htmlspecialchars($username) ?></strong></p>
        <?php endif; ?>
    </div>
</footer>

<script>
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    
    function openMobileMenu() {
        mobileMenuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileMenuFunc() {
        mobileMenuOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (burgerBtn) {
        burgerBtn.addEventListener('click', openMobileMenu);
    }
    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
    }
    
    mobileMenuOverlay.addEventListener('click', (e) => {
        if (e.target === mobileMenuOverlay) {
            closeMobileMenuFunc();
        }
    });
    
    document.querySelectorAll('.mobile-menu-content a').forEach(link => {
        link.addEventListener('click', closeMobileMenuFunc);
    });
    
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
        themeToggle.innerHTML = '☀️';
    }
    
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-theme');
        const isDark = document.body.classList.contains('dark-theme');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        themeToggle.innerHTML = isDark ? '☀️' : '🌙';
    });
    
    const scrollBtn = document.createElement('button');
    scrollBtn.id = 'scrollTop';
    scrollBtn.innerHTML = '↑';
    document.body.appendChild(scrollBtn);
    scrollBtn.addEventListener('click', () => window.scrollTo({top: 0, behavior: 'smooth'}));
    window.addEventListener('scroll', () => scrollBtn.classList.toggle('show', window.scrollY > 300));
    
    const logoutBtn = document.getElementById('logoutBtn');
    const mobileLogoutBtn = document.getElementById('mobileLogoutBtn');
    
    function handleLogout(e) {
        e.preventDefault();
        if (confirm('👋 Вы уверены, что хотите выйти?')) {
            const farewell = document.createElement('div');
            farewell.className = 'toast-notification';
            farewell.innerHTML = '👋 До свидания! Возвращайтесь скорее!';
            document.body.appendChild(farewell);
            setTimeout(() => {
                farewell.remove();
                window.location.href = logoutBtn ? logoutBtn.href : mobileLogoutBtn.href;
            }, 1500);
        }
    }
    
    if (logoutBtn) logoutBtn.addEventListener('click', handleLogout);
    if (mobileLogoutBtn) mobileLogoutBtn.addEventListener('click', handleLogout);
    
    document.querySelectorAll('.success, .error').forEach(msg => {
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });
</script>

</body>
</html>