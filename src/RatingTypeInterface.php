<?php

namespace src;

interface RatingTypeInterface
{
    public function getHtml(): string;
    public function validate($value): bool;
    public function getTypeId(): int;
}