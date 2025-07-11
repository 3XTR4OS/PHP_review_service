<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Rating/RatingTypeInterface.php';
require_once __DIR__ . '/../src/Rating/StarRating.php';
require_once __DIR__ . '/../src/Models/FeedbackModel.php';
require_once __DIR__ . '/../src/Controllers/FeedbackController.php';

$pdo = get_pdo_connection();
$ratingService = new Rating\StarRating();
$controller = new Controllers\FeedbackController($pdo, $ratingService);

$controller->handleRequest();

?>