<?php
session_start();

require_once('config.php');
if(!isset($_SESSION['user'])){
    header('Location: '.prefixeEndpoint.'/frontend/php/login.php');
    exit(0);
}

require_once ('codeFactorisé/header.php');
require_once ('codeFactorisé/menu.php');

$currentPageId = 'dashBoard';
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
