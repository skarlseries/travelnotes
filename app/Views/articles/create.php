<div style="max-width: 800px; margin: 0 auto;">
    <h2 style="color: var(--primary); margin-bottom: 1rem;">➕ Создание статьи</h2>
    <?= $message ?? '' ?>
    
    <form method="POST">
        <div class="form-group">
            <label class="form-label">Заголовок *</label>
            <input type="text" name="title" placeholder="Например: 10 лучших мест в Европе" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Краткое описание</label>
            <textarea name="excerpt" rows="2" placeholder="Краткое описание статьи (будет отображаться в списке)"></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Содержание *</label>
            <textarea name="content" rows="10" placeholder="Полный текст статьи..." required></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Статус</label>
            <select name="status">
                <option value="published">📢 Опубликовать</option>
                <option value="draft">📝 Сохранить как черновик</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
            <a href="/travelnotes/index.php?page=my_articles" class="cancel-btn">← Отмена</a>
            <button type="submit" name="create_article">✅ Опубликовать</button>
        </div>
    </form>
</div>