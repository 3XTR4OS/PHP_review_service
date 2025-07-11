<form method="POST">
    <input type="hidden" name="rating" id="rating-value" value="0" required>
    <input type="hidden" name="client_id" value="<?= (int)$clientId ?>">
    <h3 class="gradient-header">
        <?= htmlspecialchars($clientName) ?>, оцените качество нашего обслуживания!
    </h3>

    <?php
    if (isset($errorMessage)) {
        echo "<p>$errorMessage</p>";
    } ?>

    <div class="star-rating">
        <span class="star" data-value="1">★</span>
        <span class="star" data-value="2">★</span>
        <span class="star" data-value="3">★</span>
        <span class="star" data-value="4">★</span>
        <span class="star" data-value="5">★</span>
    </div>

    <textarea class="comment" name="comment" placeholder="При желании оставьте комментарий..."><?= htmlspecialchars($commentValue ?? '') ?></textarea>
    <button type="submit">Отправить отзыв</button>
</form>