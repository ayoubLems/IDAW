<?php
function renderMenuToHTML($currentPageId) {
    // un tableau qui définit la structure du site
    $mymenu = array(
        // idPage titre
        'index' => array('Accueil'),
        'cv' => array('Cv'),
        'projets' => array('Mes Projets')
    );

    echo '<nav class="menu">';
    echo '<ul>';
    
    foreach ($mymenu as $pageId => $pageParameters) {
        // Vérifiez si la page actuelle correspond à la page en cours de traitement
        $isCurrentPage = ($currentPageId === $pageId) ? ' id="currentpage"' : '';

        echo '<li><a href="' . $pageId . '.php"' . $isCurrentPage . '>' . $pageParameters[0] . '</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
}
?>
