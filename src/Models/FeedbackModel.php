<?php

namespace Models;

use PDO;

class FeedbackModel
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findClientByID(int $user_id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM USERS WHERE id = ?');
        $stmt->execute([$user_id]);

        return $stmt->fetch() ?: null;
    }

    public function saveReview(int $type_id, int $user_id, int $rating, string $comment)
    {
        $sql = "INSERT INTO reviews (review_type, user_id, comment, rating) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$type_id, $user_id, $comment, $rating]);
    }
}

