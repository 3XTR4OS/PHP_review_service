<?php

namespace src;
class StarRating implements RatingTypeInterface
{
    public function getHtml(): string
    {
        return '
            <div class="star-rating">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="rating" id="rating-value" value="0" required>';
    }

    public function validate($value): bool
    {
        // Проверяем, что значение - это целое число от 1 до 5
        $rating = filter_var($value, FILTER_VALIDATE_INT);
        return ($rating >= 1 && $rating <= 5);
    }

    public function getTypeId(): int
    {
        return 1;
    }
}