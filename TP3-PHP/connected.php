<?php
// On simule une base de données avec des utilisateurs et mots de passe
$users = array(
    // login => password
    'riri' => 'fifi',
    'yoda' => 'maitrejedi',
    'ayoub' => 'ayoub'
);

$login = "anonymous";
$errorText = "";
$successfullyLogged = false;

if(isset($_POST['login']) && isset($_POST['password'])) { // Utilisation de $_POST
    $tryLogin = $_POST['login'];
    $tryPwd = $_POST['password'];
    
    // Si le login existe et le mot de passe correspond
    if(array_key_exists($tryLogin, $users) && $users[$tryLogin] == $tryPwd) {
        $successfullyLogged = true;
        $login = $tryLogin;
    } else {
        $errorText = "Erreur de login/password";
    }
} else {
    $errorText = "Merci d'utiliser le formulaire de login";
}

if(!$successfullyLogged) {
    echo $errorText;
} else {
    echo "<h1>Bienvenue ".$login."</h1>";
}
?>
