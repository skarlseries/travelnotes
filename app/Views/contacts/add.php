<div style="padding: 1.5rem;">
    <h2 style="margin-bottom: 1rem; color: var(--accent-gold);">➕ Добавление контакта</h2>
    <?= $message ?? '' ?>
    <form method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <input type="text" name="lastname" placeholder="Фамилия" required>
            <input type="text" name="firstname" placeholder="Имя" required>
        </div>
        <input type="text" name="middlename" placeholder="Отчество">
        
        <select name="gender">
            <option>Мужской</option>
            <option>Женский</option>
        </select>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <input type="date" name="birthdate">
            <input type="text" name="phone" placeholder="Телефон">
        </div>
        
        <input type="text" name="address" placeholder="Адрес">
        <input type="email" name="email" placeholder="E-mail">
        <textarea name="comment" placeholder="Комментарий" rows="3"></textarea>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <button type="submit" name="add">➕ Добавить контакт</button>
            <a href="./index.php?page=view" class="cancel-btn">← На главную</a>
        </div>
    </form>
</div>