<?php
require_once('config.php');

$connectionString = "mysql:host=" . _MYSQL_HOST;
if(defined('_MYSQL_PORT')) {
    $connectionString .= ";port=" . _MYSQL_PORT;
}
$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

$pdo = NULL;

try {
    $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('sql/create_db.sql');

    $pdo->exec($sql);
    echo "Base de données initialisée avec succès!";
} catch (PDOException $e) {
    echo "Erreur lors de l'initialisation de la base de données : " . $e->getMessage();
}
?>
