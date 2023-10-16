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

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);
}

if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}

if(isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $id]);
}

// Sélection des utilisateurs
$request = $pdo->prepare("SELECT * from users");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_OBJ);

// Affichage des données dans un tableau HTML
echo "<table border='1'>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th>Nom</th>";
echo "<th>Email</th>";
echo "<th>Actions</th>";
echo "</tr>";
foreach ($results as $user) {
    echo "<tr>";
    echo "<td>" . $user->id . "</td>";
    echo "<td>" . $user->name . "</td>";
    echo "<td>" . $user->email . "</td>";
    echo "<td>";
    echo "<form action='' method='post'>
          <input type='hidden' name='action' value='delete'>
          <input type='hidden' name='id' value='".$user->id."'>
          <input type='submit' value='Supprimer'>
          </form>";
    echo "<form action='' method='post'>
          <input type='hidden' name='action' value='update'>
          <input type='hidden' name='id' value='".$user->id."'>
          Nom: <input type='text' name='name' value='".$user->name."'>
          Email: <input type='text' name='email' value='".$user->email."'>
          <input type='submit' value='Modifier'>
          </form>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<h3>Ajouter un utilisateur</h3>";
echo "<form action='' method='post'>";
echo "<label for='name'>Nom :</label>";
echo "<input type='text' id='name' name='name'>";
echo "<label for='email'>Email :</label>";
echo "<input type='email' id='email' name='email'>";
echo "<input type='hidden' name='action' value='add'>";
echo "<input type='submit' value='Ajouter'>";
echo "</form>";


$pdo = NULL; 