<div style="padding: 1.5rem;">
    <h2 style="color: var(--accent-gold); margin-bottom: 1.5rem;">📖 Статьи о путешествиях</h2>
    
    <?php if (empty($articles)): ?>
        <div class="error" style="text-align: center; padding: 2rem;">
            📭 Статей пока нет.
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
            <?php foreach ($articles as $article): ?>
                <div style="background: var(--bg-card); border-radius: 16px; overflow: hidden; border: 1px solid rgba(212, 175, 55, 0.15); transition: all 0.3s;">
                    <div style="padding: 1.2rem;">
                        <h3 style="margin-bottom: 0.5rem;">
                            <a href="/travelnotes/index.php?page=article&id=<?= $article['id'] ?>" style="color: var(--accent-gold); text-decoration: none;">
                                <?= htmlspecialchars($article['title']) ?>
                            </a>
                        </h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.8rem;">
                            ✍️ Автор: <?= htmlspecialchars($article['author_name'] ?? 'Неизвестен') ?> | 
                            👁️ Просмотров: <?= $article['views'] ?? 0 ?> |
                            📅 <?= date('d.m.Y', strtotime($article['created_at'] ?? 'now')) ?>
                        </p>
                        <p style="color: var(--text-secondary); line-height: 1.4;">
                            <?= htmlspecialchars(mb_substr($article['content'] ?? '', 0, 150)) ?>...
                        </p>
                        <a href="/travelnotes/index.php?page=article&id=<?= $article['id'] ?>" style="color: var(--accent-gold); text-decoration: none; display: inline-block; margin-top: 0.5rem;">Читать далее →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (isset($pages) && $pages > 1): ?>
        <div class="pagination" style="margin-top: 2rem;">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="/travelnotes/index.php?page=articles&p=<?= $i ?>" class="<?= ($i == ($current ?? 1)) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>