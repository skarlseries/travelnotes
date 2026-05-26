<div style="padding: 1.5rem;">
    <h3 style="margin-bottom: 1rem; color: var(--primary);">🗑️ Выберите запись для удаления:</h3>
    <?= $message ?? '' ?>
    
    <?php if (empty($contacts)): ?>
        <div class="error">📭 Нет контактов для удаления. <a href="/travelnotes/index.php?page=add">Добавьте первый контакт</a></div>
    <?php else: ?>
        <div class="contact-list" style="flex-direction: column;">
            <?php foreach ($contacts as $c): ?>
                <?php 
                $displayName = htmlspecialchars($c['lastname'] ?? '') . ' ' . getInitials($c['firstname'] ?? '', $c['middlename'] ?? ''); 
                ?>
                <a href="/travelnotes/index.php?page=delete&delete_id=<?= $c['id'] ?>" class="contact-item" style="justify-content: space-between;">
                    <span>👤 <?= $displayName ?></span>
                    <span style="color: var(--danger);">🗑️ удалить</span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>