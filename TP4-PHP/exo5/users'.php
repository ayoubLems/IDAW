<?php
require_once('config.php');

header('Content-Type: application/json');

$connectionString = "mysql:host=" . _MYSQL_HOST;
if (defined('_MYSQL_PORT')) {
    $connectionString .= ";port=" . _MYSQL_PORT;
}
$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$pdo = new PDO($connectionString, _MYSQL_USER, _MYSQL_PASSWORD, $options);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($users);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['name']) && isset($data['email'])) {
            $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$data['name'], $data['email']]);
            http_response_code(201); // Created
            echo json_encode(['id' => $pdo->lastInsertId()]);
        } else {
            http_response_code(400); // Bad Request
        }
        break;

    case 'PUT':
        $id = $_GET['id'] ?? null;
        $data = json_decode(file_get_contents('php://input'), true);
        if ($id && isset($data['name']) && isset($data['email'])) {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$data['name'], $data['email'], $id]);
            http_response_code(200); // OK
        } else {
            http_response_code(400); // Bad Request
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            http_response_code(200); // OK
        } else {
            http_response_code(400); // Bad Request
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        break;
}

$pdo = NULL;
?>
