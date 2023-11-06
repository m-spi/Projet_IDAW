<?php
function renderMenuToHTML($currentPageId)
{
// Un tableau qui définit la structure du menu
$mymenu = array(

'dashBoard' => array('Accueil','Mon tableau de bord'),
'journal' => array('Historique','Mon journal'),
'aliments' => array('Ajouter un aliment','Mes aliments'),
);

echo '<div id="layoutSidenav_nav"> <!--menu-->
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu"> <!--menuContent-->
                <div class="nav">';
            foreach ($mymenu as $pageId => $pageParameters) {
            $currentClass = ($pageId === $currentPageId) ? ' id="currentPage"' : ''; // Ajout de la classe 'id="currentPage"' pour la page courante
                echo '<div class="sb-sidenav-menu-heading">'.$pageParameters[0].'</div>
                            <a class="nav-link" href="index.php?page='.$pageId.'"'.$currentClass.'>
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                '.$pageParameters[1].'
                </a>';
            }
            echo'</div>
            </div>
                <div class="sb-sidenav-footer">
                    Traque Ta Bouffe
                </div>
        </nav>
     </div>';
}

?>




