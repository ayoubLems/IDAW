<?php

require_once('config.php');

$connectionString = "mysql:host=" . _MYSQL_HOST;
if(defined('_MYSQL_PORT')) {
    $connectionString .= ";port=" . _MYSQL_PORT;
}
$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

$pdo = NULL;
$response = []; 

header('Content-Type: application/json');

try {
    $pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    $response['error'] = 'Erreur : ' . $erreur->getMessage();
    echo json_encode($response);
    exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);
    $response['status'] = 'User added successfully';
}

if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $response['status'] = 'User deleted successfully';
}

if(isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $id]);
    $response['status'] = 'User updated successfully';
}

// Get users from the database
$request = $pdo->prepare("SELECT * from users");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_OBJ);
$response['users'] = $results;

echo json_encode($response);

$pdo = NULL;
