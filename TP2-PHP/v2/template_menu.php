<?php
function renderMenuToHTML($currentPageId, $currentLang) {
    $mymenu = array(
        'accueil' => 'Accueil',
        'cv' => 'Cv',
        'projets' => 'Mes projets',
        'contact' => 'Contact'
    );

    echo '<nav class="menu">';
    echo '<ul>';
    foreach ($mymenu as $pageId => $pageParameters) {
        $link = "index.php?page=" . $pageId . "&lang=" . $currentLang;

        if ($pageId == $currentPageId) {
            echo '<li><a id="currentpage" href="' . $link . '">' . $pageParameters . '</a></li>';
        } else {
            echo '<li><a href="' . $link . '">' . $pageParameters . '</a></li>';
        }
    }
    echo '</ul>';
    echo '</nav>';
}
?>
