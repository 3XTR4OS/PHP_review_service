<?php
require_once 'config.php'; // Наш файл для подключения к БД
require_once 'src/RatingTypeInterface.php';
require_once 'src/StarRating.php';


$pdo = get_pdo_connection();
$client = null;
$errorMessage = '';
$formSubmitted = false;
$ratingType = new \src\StarRating();

$clientId = filter_input(INPUT_GET, 'client_id', FILTER_VALIDATE_INT);
$query = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$query->execute([$clientId]);
$client = $query->fetch();
$commentValue = ''; //

if ($_POST){
    if ($_POST['rating'] == 0) {
        $errorMessage = 'Пожалуйста, не забудьте поставить оценку!';
        $commentValue = $_POST['comment'];
    }
    else {
        $formSubmitted = true;
        $sql = "INSERT INTO reviews (review_type, client_id, comment, rating) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ratingType->getTypeId(), $clientId, $_POST['comment'], $_POST['rating']]);
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

<?php if (!$client): ?>
    <!-- Клиент не найден или ID не передан. Заглушка. -->
    <div class="feedback-card">
        <h3>Ссылка на голосование недоступна</h3>
        <p>Пожалуйста, свяжитесь с нами для уточнения деталей.</p>
    </div>

<?php elseif ($formSubmitted): ?>
    <!-- Форма успешно отправлена. Показываем "Спасибо". -->
    <div class="feedback-card">
        <h3 class="gradient-header">Спасибо за ваш отзыв!</h3>
        <p>Ваше мнение очень важно для нас.</p>
    </div>

<?php else: ?>
    <!-- Клиент найден, форма еще не отправлена. Показываем форму. -->
    <div class="feedback-card">
        <h3 class="gradient-header"> <?=$clientName = $client['Name']; $clientName?>, оцените качество нашего обслуживания!</h3>

        <?php if ($errorMessage): ?>
            <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>

        <form method="POST" action="?client_id=<?= (int)$clientId ?>">
            <?= $ratingType->getHtml() ?>
            <textarea class="comment" name="comment" placeholder="При желании оставьте комментарий..."><?php
                if ($commentValue) {
                    echo htmlspecialchars($commentValue);
                }
                ?>
</textarea>
            <button type="submit">Отправить отзыв</button>
        </form>

    </div>
<?php endif; ?>

<script src="./stars.js"></script>
</body>
<script src="./stars.js"></script>
</html>