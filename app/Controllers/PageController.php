<?php
declare(strict_types=1);

class PageController extends Controller
{
    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function about(array $get, array $post): array
    {
        ob_start();
        ?>
        <div style="padding: 1.5rem; max-width: 800px; margin: 0 auto;">
            <h2 style="color: var(--accent-gold); margin-bottom: 1rem;">🌍 О проекте TravelNotes</h2>

            <div style="background: rgba(212, 175, 55, 0.05); padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
                <p><strong>TravelNotes</strong> — это веб-сервис для путешественников, созданный в рамках курсового проекта по основам серверной веб-разработки.</p>
            </div>

            <h3 style="color: var(--accent-gold); margin-bottom: 0.5rem;">📋 Возможности сервиса:</h3>
            <ul style="margin-left: 1.5rem; color: var(--text-secondary);">
                <li>📇 Хранение контактов туристов (записная книжка)</li>
                <li>➕ Добавление, редактирование и удаление контактов</li>
                <li>📊 Сортировка и пагинация списка контактов</li>
                <li>📖 Публикация и просмотр статей о путешествиях</li>
                <li>✍️ Авторы статей из числа пользователей</li>
                <li>🔐 Регистрация и авторизация пользователей</li>
                <li>📧 Форма обратной связи с отправкой на httpbin.org</li>
                <li>👋 Страницы приветствия и прощания</li>
            </ul>

            <h3 style="color: var(--accent-gold); margin: 1rem 0 0.5rem;">🛠️ Технологии:</h3>
            <ul style="margin-left: 1.5rem; color: var(--text-secondary);">
                <li>PHP 8.2 (MVC архитектура)</li>
                <li>MySQL (PDO)</li>
                <li>HTML5 / CSS3 (адаптивный дизайн)</li>
                <li>cURL (отправка формы)</li>
            </ul>

            <h3 style="color: var(--accent-gold); margin: 1rem 0 0.5rem;">👨‍💻 Автор: Мясников Никита Романович</h3>
            <p style="color: var(--text-secondary);">Курсовой проект по дисциплине «Основы серверной веб-разработки</p>
            <p style="color: var(--text-secondary);">Московский Политехнический Университет, 2026</p>

            <br>
            <a href="/travelnotes/index.php" class="cancel-btn">← На главную</a>
        </div>
        <?php
        $content = (string) ob_get_clean();

        return ['title' => 'О проекте', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function feedback(array $get, array $post): array
    {
        $result_message = '';
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $ch = curl_init('https://httpbin.org/post');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $result_message = $response
                ? "<div class='success'>✅ Форма отправлена успешно!</div>"
                : "<div class='error'>❌ Ошибка отправки</div>";
        }

        ob_start();
        ?>
        <div style="padding: 1.5rem; max-width: 600px; margin: 0 auto;">
            <h2 style="color: var(--accent-gold); text-align: center;">📧 Обратная связь</h2>
            <?= $result_message ?>
            <form method="POST">
                <input type="text" name="name" placeholder="Имя пользователя" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <select name="type">
                    <option>Жалоба</option>
                    <option>Предложение</option>
                    <option>Благодарность</option>
                </select>
                <textarea name="message" placeholder="Текст обращения" rows="5" required></textarea>
                <label><input type="checkbox" name="sms"> SMS</label>
                <label><input type="checkbox" name="email_answer"> E-mail</label>
                <button type="submit" style="width: 100%;">Отправить</button>
            </form>
            <br>
            <a href="/travelnotes/index.php?page=headers" class="cancel-btn">→ Посмотреть заголовки (get_headers)</a>
        </div>
        <?php
        $content = (string) ob_get_clean();

        return ['title' => 'Форма обратной связи', 'content' => $content];
    }

    /**
     * @param array<string, mixed> $get
     * @param array<string, mixed> $post
     * @return array{title: string, content: string}
     */
    public function headers(array $get, array $post): array
    {
        $headers = get_headers('https://httpbin.org/post', true);
        ob_start();
        ?>
        <div style="padding: 1.5rem;">
            <h2>📋 Результат get_headers()</h2>
            <textarea rows="20" readonly style="width:100%; background:#1a1a1a; color:#0f0; padding:1rem; border-radius:12px; font-family:monospace;"><?php print_r($headers); ?></textarea>
            <br><br>
            <a href="/travelnotes/index.php?page=feedback" class="cancel-btn">← Вернуться к форме</a>
        </div>
        <?php
        $content = (string) ob_get_clean();

        return ['title' => 'HTTP Headers', 'content' => $content];
    }
}
