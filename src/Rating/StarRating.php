<?php

namespace Rating;

class StarRating implements RatingTypeInterface
{
    public function validate($value): bool
    {
        $rating = filter_var($value, FILTER_VALIDATE_INT);
        return ($rating >= 1 && $rating <= 5);
    }

    public function getTypeId(): int
    {
        return 1;
    }
}