<?php

namespace Rating;

interface RatingTypeInterface
{
    public function validate($value): bool;
    public function getTypeId(): int;
}