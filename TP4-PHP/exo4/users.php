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

$request = $pdo->prepare("SELECT * from users");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_OBJ);

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Gestion des utilisateurs</title>";
echo "<style>";


echo "
body {
    font-family: 'Poppins', sans-serif;
    background-color: #EAEDED;
    padding: 50px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: separate;
    margin: 30px 0;
    background-color: #FFFFFF;
    box-shadow: 10px 10px 30px #D0D3D4, -10px -10px 30px #FFFFFF;
    border-radius: 15px;
    overflow: hidden;
}

th, td {
    padding: 12px 18px;
    border-bottom: 1px solid #F2F3F4;
    text-align: left;
}

th {
    background-color: #4A90E2; /* Blue color for headers */
    color: #FFFFFF;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

tr:last-child td {
    border-bottom: none;
}

tr:nth-child(even) {
    background-color: #FBFCFC;
}

tr:hover {
    background-color: #F2F3F4;
    cursor: default;
}

/* Stylized buttons */
input[type=submit] {
    padding: 10px 20px;
    border: none;
    background: #4A90E2; /* Blue color for buttons */
    box-shadow: 6px 6px 12px #D0D3D4, -6px -6px 12px #FFFFFF;
    color: #FFFFFF;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    border-radius: 50px;
    font-weight: 600;
}

input[type=submit]:hover {
    background: #357ABD; /* Darker blue on hover */
}

input[type=submit]:active {
    background: #2E64A5; /* Even darker blue for active state */
}

/* Stylized input fields */
input[type=text], input[type=email] {
    padding: 10px 18px;
    margin: 0 12px;
    background: #FFFFFF;
    border: none;
    border-radius: 25px;
    box-shadow: 6px 6px 12px #D0D3D4, -6px -6px 12px #FFFFFF;
    font-size: 16px;
    color: #333;
    transition: box-shadow 0.3s;
}

input[type=text]:focus, input[type=email]:focus {
    box-shadow: inset 4px 4px 8px #D0D3D4, inset -4px -4px 8px #FFFFFF;
    outline: none;
}

h3 {
    font-size: 32px;
    margin-bottom: 24px;
    font-weight: 600;
    letter-spacing: 1.5px;
    color: #4A90E2; /* Blue color for titles */
}

form {
    background-color: #FFFFFF;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 10px 10px 30px #D0D3D4, -10px -10px 30px #FFFFFF;
    margin-bottom: 40px;
}
";

echo "</style>";
echo "</head>";


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