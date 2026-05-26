<div style="padding: 1.5rem;">
    <h1 style="color: var(--accent-gold);"><?= htmlspecialchars($article['title']) ?></h1>
    <p style="color: var(--text-muted); margin-bottom: 1rem;">✍️ Автор: <?= htmlspecialchars($article['author_name'] ?? 'Неизвестен') ?></p>
    <div style="background: rgba(212, 175, 55, 0.05); padding: 1.5rem; border-radius: 16px;">
        <?= nl2br(htmlspecialchars($article['content'])) ?>
    </div>
    <br>
    <a href="/travelnotes/index.php?page=articles" class="cancel-btn">← К списку статей</a>
</div>