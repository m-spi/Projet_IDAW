<?php
require_once ('codeFactorisé/header.php');
require_once ('codeFactorisé/menu.php');

$currentPageId = 'accueil';
if(isset($_GET['page']))
{
    $currentPageId = $_GET['page'];
}

renderMenuToHTML($currentPageId);
?>

    <?php
    $pageToInclude = $currentPageId . ".php";
    if(is_readable($pageToInclude))
        require_once($pageToInclude);
    else
        require_once("../../node_modules/startbootstrap-sb-admin/dist/404.html");
    ?>

<?php
require_once ('codeFactorisé/footer.php') ?>
