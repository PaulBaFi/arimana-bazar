<?php

class Conexion
{
    public static function conectar()
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $db_name = "arimanabazar";

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$db_name", "$username", "$password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            header("Location: index.php?action=index&error=db");
            exit;
        }
    }
}
