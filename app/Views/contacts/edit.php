<div class="edit-container">
    <h3 class="edit-title">✏️ Выберите контакт для редактирования:</h3>
</div>

<div class="contact-list">
    <?php foreach ($contacts as $c): ?>
        <?php 
        $displayName = htmlspecialchars($c['lastname']) . ' ' . getInitials($c['firstname'], $c['middlename']);
        $isActive = ($c['id'] == $id);
        ?>
        <a href="/travelnotes/index.php?page=edit&id=<?= $c['id'] ?>" class="contact-item <?= $isActive ? 'active' : '' ?>">
            👤 <?= $displayName ?>
        </a>
    <?php endforeach; ?>
</div>

<?= $message ?? '' ?>

<form method="POST" class="edit-form">
    <div class="form-row">
        <input type="text" name="lastname" value="<?= htmlspecialchars($contact['lastname'] ?? '') ?>" placeholder="Фамилия" required>
        <input type="text" name="firstname" value="<?= htmlspecialchars($contact['firstname'] ?? '') ?>" placeholder="Имя" required>
    </div>
    <input type="text" name="middlename" value="<?= htmlspecialchars($contact['middlename'] ?? '') ?>" placeholder="Отчество">

    <select name="gender">
        <option value="Мужской" <?= ($contact['gender'] ?? '') == 'Мужской' ? 'selected' : '' ?>>Мужской</option>
        <option value="Женский" <?= ($contact['gender'] ?? '') == 'Женский' ? 'selected' : '' ?>>Женский</option>
    </select>

    <div class="form-row">
        <input type="date" name="birthdate" value="<?= htmlspecialchars($contact['birthdate'] ?? '') ?>">
        <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>" placeholder="Телефон">
    </div>

    <input type="text" name="address" value="<?= htmlspecialchars($contact['address'] ?? '') ?>" placeholder="Адрес">
    <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>" placeholder="E-mail">
    <textarea name="comment" placeholder="Комментарий" rows="3"><?= htmlspecialchars($contact['comment'] ?? '') ?></textarea>

    <div class="form-actions">
        <button type="submit" name="update">💾 Сохранить изменения</button>
        <a href="/travelnotes/index.php?page=view" class="cancel-btn">← Отмена</a>
    </div>
</form>