<?php
  require_once('init_pdo.php');

  $file = file_get_contents("./sql/TraqueTaBouffe.sql");
  $request = $pdo->prepare($file);

  $request->execute();

  require_once('populate.php');

  /*** close the database connection ***/
  $pdo = null;
?>
