<?php

function getPdo()
{
    $host = getenv("DB_HOST") ?: "127.0.0.1";
    $username = getenv("DB_USER") ?: "admin";
    $password = getenv("DB_PASSWORD") ?: "root";
    $dbname = getenv("DB_NAME") ?: "blog";

    try {
        $connection = new PDO(
            "mysql:host=$host;dbname=$dbname",
            $username,
            $password,
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $e) {
        die($e);
    }
}
