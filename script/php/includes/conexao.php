<?php

$host = "localhost";
$db = "sistema_gestao_clinica";
$user = "root";
$pass = "root1234";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

?>
