<?php

function get_pdo_connection(): PDO
{
    $db_file = __DIR__ . '/rdatabase.db';
    $dsn = 'sqlite:' . $db_file;

    try{
        $pdo = new PDO($dsn); // PDO - объект
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Показывать ошибки
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Без числовых индексов
        $pdo->exec('PRAGMA foreign_keys = ON'); // Поддержка внешних ключей

        return $pdo;

    } catch (PDOException $exception) {
        die("Произошла ошибка подключения к БД: " . $exception->getMessage());}
}

