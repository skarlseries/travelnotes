<?php
$name = $name ?? 'Гость';
if (empty($name)) {
    $name = 'Гость';
}
?>
<div style="padding: 1.5rem; text-align: center;">
    <h2 style="color: var(--primary); font-size: 1.8rem; margin-bottom: 1rem;">👋 Привет, <?= htmlspecialchars($name) ?>!</h2>
    <p style="color: var(--text-secondary); margin: 1rem 0; font-size: 1.1rem;">Добро пожаловать в TravelNotes!</p>
    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Здесь вы найдёте интересные статьи о путешествиях и сможете хранить контакты попутчиков.</p>
    <a href="/travelnotes/index.php" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
        🏠 На главную
    </a>
</div>