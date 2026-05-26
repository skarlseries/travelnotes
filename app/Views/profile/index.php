<div style="padding: 1.5rem;">
    <h2 style="color: var(--accent-gold); margin-bottom: 1rem;">👤 Мой профиль</h2>
    
    <div style="background: rgba(212, 175, 55, 0.05); padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
        <p><strong>Имя пользователя:</strong> <?= htmlspecialchars($user['username'] ?? '') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
        <p><strong>Роль:</strong> <?= htmlspecialchars($user['role'] ?? 'user') ?></p>
        <p><strong>О себе:</strong> <?= htmlspecialchars($user['bio'] ?? 'Не указано') ?></p>
        <p><strong>Страна:</strong> <?= htmlspecialchars($user['country'] ?? 'Не указана') ?></p>
        <p><strong>Дата регистрации:</strong> <?= isset($user['created_at']) ? date('d.m.Y', strtotime($user['created_at'])) : 'Неизвестно' ?></p>
    </div>
    
    <h3 style="color: var(--accent-gold); margin: 1rem 0;">📊 Статистика</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
        <div style="background: rgba(212, 175, 55, 0.05); padding: 1rem; border-radius: 12px; text-align: center;">
            <h4>📇 Контакты</h4>
            <p style="font-size: 2rem;"><?= count($contacts ?? []) ?></p>
        </div>
        <div style="background: rgba(212, 175, 55, 0.05); padding: 1rem; border-radius: 12px; text-align: center;">
            <h4>✈️ Поездки</h4>
            <p style="font-size: 2rem;"><?= count($trips ?? []) ?></p>
        </div>
        <div style="background: rgba(212, 175, 55, 0.05); padding: 1rem; border-radius: 12px; text-align: center;">
            <h4>📝 Статьи</h4>
            <p style="font-size: 2rem;"><?= count($articles ?? []) ?></p>
        </div>
    </div>
    
    <?php if (!empty($contacts)): ?>
    <?php
    $totalAge = 0;
    $ageCount = 0;
    $zodiacStats = [];
    
    foreach ($contacts as $contact) {
        if (!empty($contact['birthdate']) && $contact['birthdate'] !== '0000-00-00') {
            $age = (new DateTime($contact['birthdate']))->diff(new DateTime('today'))->y;
            $totalAge += $age;
            $ageCount++;
            
            $zodiac = getZodiacSign($contact['birthdate']);
            if ($zodiac !== '—') {
                $zodiacStats[$zodiac] = ($zodiacStats[$zodiac] ?? 0) + 1;
            }
        }
    }
    
    $avgAge = $ageCount > 0 ? round($totalAge / $ageCount, 1) : 0;
    ?>
    <h3 style="color: var(--accent-gold); margin: 1rem 0;">📈 Дополнительная аналитика</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
        <div style="background: rgba(212, 175, 55, 0.05); padding: 1rem; border-radius: 12px;">
            <h4>🎂 Средний возраст</h4>
            <p style="font-size: 1.5rem;"><?= $avgAge ?> лет</p>
            <small>на основе <?= $ageCount ?> контактов</small>
        </div>
        <div style="background: rgba(212, 175, 55, 0.05); padding: 1rem; border-radius: 12px;">
            <h4>♈ Популярные знаки зодиака</h4>
            <?php if (!empty($zodiacStats)): ?>
                <?php arsort($zodiacStats); ?>
                <?php foreach (array_slice($zodiacStats, 0, 3) as $sign => $count): ?>
                    <p><?= $sign ?>: <?= $count ?> чел.</p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет данных</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <br>
    <a href="/travelnotes/index.php?page=view" class="cancel-btn">← На главную</a>
</div>