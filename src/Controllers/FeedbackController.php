<?php

namespace Controllers;

use PDO;
use Models\FeedbackModel;
use Rating\RatingTypeInterface;

class FeedbackController
{
    private PDO $pdo;
    private RatingTypeInterface $ratingService;
    private FeedbackModel $feedbackModel;

    public function __construct(PDO $pdo, RatingTypeInterface $ratingService)
    {
        $this->pdo = $pdo;
        $this->ratingService = $ratingService;
        $this->feedbackModel = new FeedbackModel($this->pdo);
    }

    // Главный метод-маршрутизатор
    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processSubmission();
        } else {
            $this->showForm();
        }
    }

    // Показывает форму отзыва
    public function showForm(): void

    {
        $clientId = filter_input(INPUT_GET, 'client_id', FILTER_VALIDATE_INT);

        if (!$clientId) {
            $this->render('error.php');
            return;
        }

        $client = $this->feedbackModel->findClientById($clientId);

        if (!$client) {
            $this->render('error.php');
            return;
        }

        $this->render('feedback_form.php', [
            'clientName' => $client['Name'],
            'clientId' => $clientId
        ]);
    }

    // Обрабатывает отправленные данные
    public function processSubmission(): void
    {
        $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
        $rating = $_POST['rating'] ?? 0;
        $comment = trim($_POST['comment'] ?? '');

        // Валидация
        if (!$clientId || !$this->ratingService->validate($rating)) {
            $client = $this->feedbackModel->findClientById($clientId);
            $this->render('feedback_form.php', [
                'clientName' => $client['Name'] ?? 'Клиент',
                'clientId' => $clientId,
                'errorMessage' => 'Пожалуйста, поставьте оценку от 1 до 5.',
                'commentValue' => $comment,
            ]);
            return;
        }

        // Сохранение
        $this->feedbackModel->saveReview(
            $this->ratingService->getTypeId(),
            $clientId,
            (int)$rating,
            $comment
        );

        $this->render('thank_you.php');
    }

    private function render(string $viewName, array $data = []): void
    {
        extract($data);

        $current_view = __DIR__ . '/../../views/' . $viewName;

        require __DIR__ . '/../../views/layout.php';
    }
}