<?php

require_once 'config.php';
require_once 'src/RatingTypeInterface.php';
require_once 'src/StarRating.php';

$pdo = get_pdo_connection();
$activeRating = new \src\StarRating();

$viewData = [
    'client'       => null,
    'errorMessage' => '',
    'commentValue' => '',
    'clientId'     => null,
];
$viewName = 'not_found';
$clientId = filter_input(INPUT_GET, 'client_id', FILTER_VALIDATE_INT);

if ($clientId) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$clientId]);
    $client = $stmt->fetch();

    if ($client) {
        $viewName = 'form';
        $viewData['client'] = $client;
        $viewData['clientId'] = $clientId;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = $_POST['rating'] ?? 0; // null coalescing operator
            $comment = trim($_POST['comment'] ?? '');

            if ($activeRating->validate($rating)) {
                $sql = "INSERT INTO reviews (review_type, client_id, comment, rating) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$activeRating->getTypeId(), $clientId, $comment, $rating]);

                $viewName = 'thank_you';
            } else {
                $viewData['errorMessage'] = 'Пожалуйста, поставьте оценку от 1 до 5.';
                $viewData['commentValue'] = $comment;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оставьте отзыв!</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if ($viewName === 'not_found'): ?>
    <div class="feedback-card">
        <h3>Ссылка на голосование недоступна</h3>
        <p>Пожалуйста, свяжитесь с нами для уточнения деталей.</p>
    </div>

<?php elseif ($viewName === 'thank_you'): ?>
    <div class="feedback-card">
        <h3 class="gradient-header">Спасибо за ваш отзыв!</h3>
        <p>Ваше мнение очень важно для нас.</p>
    </div>

<?php elseif ($viewName === 'form'): ?>
    <div class="feedback-card">
        <h3 class="gradient-header">
            <?php // XSS-уязвимость(была). Теперь экранирую вывод! ?>
            <?= htmlspecialchars($viewData['client']['Name']) ?>, оцените качество нашего обслуживания!
        </h3>

        <?php if ($viewData['errorMessage']): ?>
            <p class="error-message"><?= htmlspecialchars($viewData['errorMessage']) ?></p>
        <?php endif; ?>

        <form method="POST" action="?client_id=<?= (int)$viewData['clientId'] ?>">
            <?= $activeRating->getHtml() ?>
            <textarea class="comment" name="comment" placeholder="При желании оставьте комментарий..."><?= htmlspecialchars($viewData['commentValue']) ?></textarea>
            <button type="submit">Отправить отзыв</button>
        </form>
    </div>
<?php endif; ?>

<script src="./stars.js"></script>
</body>
</html>