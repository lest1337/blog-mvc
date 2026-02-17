<?php

function getPdo()
{
    $USERNAME = "blog_user";
    $PASSWORD = "password";
    $DBNAME = "blog";
    $HOST = "127.0.0.1";

    try {
        $connection = new PDO(
            "mysql:host=$HOST;dbname=$DBNAME",
            $USERNAME,
            $PASSWORD,
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $e) {
        die($e);
    }
}
