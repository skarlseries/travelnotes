<div style="padding: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: var(--primary);">📝 Мои статьи</h2>
        <a href="/travelnotes/index.php?page=article_create" class="btn-primary">➕ Создать статью</a>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="success">
            <?php if ($_GET['success'] == 'created'): ?>✅ Статья создана
            <?php elseif ($_GET['success'] == 'updated'): ?>✅ Статья обновлена
            <?php elseif ($_GET['success'] == 'deleted'): ?>🗑️ Статья удалена
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($articles)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <div class="empty-state-title">У вас пока нет статей</div>
            <div class="empty-state-text">Создайте свою первую статью о путешествиях</div>
            <a href="/travelnotes/index.php?page=article_create" class="btn-primary">➕ Создать статью</a>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($articles as $article): ?>
                <div style="background: var(--bg-card); border-radius: var(--radius-lg); padding: 1.25rem; border: 1px solid rgba(67, 97, 238, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                        <div style="flex: 1;">
                            <h3 style="margin-bottom: 0.5rem;">
                                <a href="/travelnotes/index.php?page=article&id=<?= $article['id'] ?>" style="color: var(--primary); text-decoration: none;">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h3>
                            <div class="article-meta">
                                👁️ <?= $article['views'] ?? 0 ?> просмотров | 
                                📅 <?= date('d.m.Y', strtotime($article['created_at'])) ?>
                                <?php if (($article['status'] ?? 'published') == 'draft'): ?>
                                    | <span class="badge">📝 Черновик</span>
                                <?php endif; ?>
                            </div>
                            <p style="color: var(--text-secondary); margin-top: 0.5rem;">
                                <?= htmlspecialchars(mb_substr($article['content'] ?? '', 0, 150)) ?>...
                            </p>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="/travelnotes/index.php?page=article_edit&id=<?= $article['id'] ?>" class="btn-sm">✏️ Редактировать</a>
                            <a href="/travelnotes/index.php?page=article_delete&id=<?= $article['id'] ?>" class="btn-sm btn-danger" onclick="return confirm('Удалить статью?')">🗑️ Удалить</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="/travelnotes/index.php?page=my_articles&p=<?= $i ?>" class="<?= $i == $current ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>