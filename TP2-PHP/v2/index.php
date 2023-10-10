<?php
$defaultLang = 'fr'; // Langue par défaut (français)
$availableLangs = ['fr', 'en']; // Langues disponibles
$currentLang = isset($_GET['lang']) && in_array($_GET['lang'], $availableLangs) ? $_GET['lang'] : $defaultLang;

$currentPageId = 'accueil'; // Page par défaut
if (isset($_GET['page'])) {
    $currentPageId = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site Web Personnel</title>
    <!-- Mettez ici vos balises meta, liens CSS, etc. -->
</head>
<body>
    <?php
    require_once('template_header.php');
    require_once('template_menu.php');
    ?>

    <header class="bandeau_haut">
        <h1 class="titre">Mon Site Web Personnel</h1>
    </header>

    <?php
    renderMenuToHTML($currentPageId, $currentLang);
    ?>

    <section class="corps">
        <?php
        $pageToInclude = $currentLang . '/' . $currentPageId . ".php";
        if (is_readable($pageToInclude)) {
            require_once($pageToInclude);
        } else {
            require_once("error.php");
        }
        ?>
    </section>

    <?php
    require_once("footer.php");
    ?>
</body>
</html>
