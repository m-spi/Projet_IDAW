<?php
  require_once('init_pdo.php');

  $file = file_get_contents("./sql/TraqueTaBouffe.sql");
  $request = $pdo->prepare($file);

  $request->execute();

  /*** close the database connection ***/
  $pdo = null;
?>
