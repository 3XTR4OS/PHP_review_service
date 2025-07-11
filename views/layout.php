<!DOCTYPE html>
<html lang="ru">
<body>
<head>
    <meta charset="UTF-8">
    <title>Оставьте отзыв!</title>
    <link rel="stylesheet" href="../public/css/styles.css">
</head>
<div class="feedback-card">
    <?php
    // $current_view устанавливается в методе render() контроллера
    if (isset($current_view) && file_exists($current_view)) {
        require_once $current_view;
    } else {
        require_once 'error.php';
    }
    ?></div>

<script src="../public/js/stars.js"></script>
</body>