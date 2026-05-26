<div style="max-width: 800px; margin: 0 auto;">
    <h2 style="color: var(--primary); margin-bottom: 1rem;">✏️ Редактирование статьи</h2>
    
    <form method="POST">
        <div class="form-group">
            <label class="form-label">Заголовок *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($article['title'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Краткое описание</label>
            <textarea name="excerpt" rows="2"><?= htmlspecialchars($article['excerpt'] ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Содержание *</label>
            <textarea name="content" rows="10" required><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Статус</label>
            <select name="status">
                <option value="published" <?= ($article['status'] ?? '') == 'published' ? 'selected' : '' ?>>📢 Опубликовать</option>
                <option value="draft" <?= ($article['status'] ?? '') == 'draft' ? 'selected' : '' ?>>📝 Черновик</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
            <a href="/travelnotes/index.php?page=my_articles" class="cancel-btn">← Отмена</a>
            <button type="submit" name="update_article">💾 Сохранить</button>
        </div>
    </form>
</div>