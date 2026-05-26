<div style="padding: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="color: var(--accent-gold);">📇 Мои контакты</h2>
        <a href="/travelnotes/index.php?page=add" class="btn-primary">➕ Добавить контакт</a>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="success">
            <?php if ($_GET['success'] == 'added'): ?>✅ Контакт добавлен
            <?php elseif ($_GET['success'] == 'updated'): ?>✅ Контакт обновлён
            <?php elseif ($_GET['success'] == 'deleted'): ?>🗑️ Контакт удалён
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if (empty($contacts)): ?>
        <div class="error" style="text-align: center; padding: 2rem;">
            📭 У вас пока нет контактов. <a href="/travelnotes/index.php?page=add">Добавьте первый</a>
        </div>
    <?php else: ?>
        <div class="submenu" style="margin-bottom: 1rem;">
            <span style="margin-right: 10px;">📊 Сортировать:</span>
            <a href="/travelnotes/index.php?page=view&sort=lastname" class="<?= $sort == 'lastname' ? 'active' : '' ?>">По фамилии</a>
            <a href="/travelnotes/index.php?page=view&sort=firstname" class="<?= $sort == 'firstname' ? 'active' : '' ?>">По имени</a>
            <a href="/travelnotes/index.php?page=view&sort=birthdate" class="<?= $sort == 'birthdate' ? 'active' : '' ?>">По дате рождения</a>
            <a href="/travelnotes/index.php?page=view&sort=created_at" class="<?= $sort == 'created_at' ? 'active' : '' ?>">По добавлению</a>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="contacts-table">
                <thead>
                    <tr>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>📅 Дата рождения</th>
                        <th>🎂 Возраст</th>
                        <th>♈ Знак зодиака</th>
                        <th>📞 Телефон</th>
                        <th>📧 Email</th>
                        <th>📍 Адрес</th>
                        <th>💬 Комментарий</th>
                        <th>⚡ Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['lastname']) ?></td>
                        <td><?= htmlspecialchars($contact['firstname']) ?></td>
                        <td><?= htmlspecialchars($contact['middlename']) ?></td>
                        <td><?= htmlspecialchars($contact['gender']) ?></td>
                        <td><?= htmlspecialchars($contact['birthdate']) ?></td>
                        
                        <td><?= calculateAge($contact['birthdate']) ?></td>
                        
                        <td><?= getZodiacSign($contact['birthdate']) ?></td>
                        <td><?= htmlspecialchars($contact['phone']) ?></td>
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><?= htmlspecialchars($contact['address']) ?></td>
                        <td><?= htmlspecialchars($contact['comment']) ?></td>
                        <td>
                            <a href="/travelnotes/index.php?page=edit&id=<?= $contact['id'] ?>" class="btn-sm" title="Редактировать">✏️</a>
                            <a href="/travelnotes/index.php?page=delete&delete_id=<?= $contact['id'] ?>" class="btn-sm btn-danger" title="Удалить" onclick="return confirm('Удалить контакт?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="/travelnotes/index.php?page=view&p=<?= $i ?>&sort=<?= $sort ?>" class="<?= $i == $current ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        
        <div class="stats">
            Всего: <strong><?= $total ?></strong> контактов
        </div>
    <?php endif; ?>
</div>