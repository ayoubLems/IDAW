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
    $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    echo 'Erreur : ' . $erreur->getMessage();
    exit;
}

$request = $pdo->prepare("SELECT * from users");
$request->execute();

$results = $request->fetchAll(PDO::FETCH_OBJ);

// Affichage des données dans un tableau HTML
echo "<table border='1'>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th>Nom</th>";
echo "<th>Email</th>";
echo "</tr>";
foreach ($results as $user) {

    // print_r($user);
    echo "<tr>";
    echo "<td>" . $user->id . "</td>";
    echo "<td>" . $user->name . "</td>";
    echo "<td>" . $user->email . "</td>";
    echo "</tr>";
}
echo "</table>";

$pdo = NULL; // Fermer la connexion à la base de données

?>
