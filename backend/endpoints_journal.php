<?php
function getAll($pdo){
  $request = $pdo->prepare(
      "SELECT ID_REPAS AS id, ID_ALIMENT_FK AS id_aliment, ID_USER_FK AS id_user, `DATE` AS `date`, QUANTITE as quantite
       FROM ALIMENT_CONSOMME
       ORDER BY `date` DESC"
  );

  $request->execute();
  $res = $request->fetchAll(PDO::FETCH_ASSOC);

  $res = array("journal" => $res);
  $res = array(
      "http_status" => 200,
      "response" => "OK",
      "result" => $res
  );

  http_response_code(200);
  return json_encode($res);
}

function getUserAll($pdo, $id){
  $request = $pdo->prepare(
      "SELECT ID_REPAS AS id, ID_ALIMENT_FK AS id_aliment, ID_USER_FK AS id_user, `DATE` AS `date`, QUANTITE as quantite
       FROM ALIMENT_CONSOMME
       WHERE ID_USER_FK = {$id}
       ORDER BY `date` DESC"
  );

  $request->execute();
  $res = $request->fetchAll(PDO::FETCH_ASSOC);

  $res = array("journal" => $res);
  $res = array(
      "http_status" => 200,
      "response" => "OK",
      "result" => $res
  );

  http_response_code(200);
  return json_encode($res);
}

function getOne($pdo, $id){
  $request = $pdo->prepare(
      "SELECT ID_REPAS AS id, ID_ALIMENT_FK AS id_aliment, ID_USER_FK AS id_user, `DATE` AS `date`, QUANTITE as quantite
       FROM ALIMENT_CONSOMME
       WHERE ID_REPAS = {$id}"
  );
  $request->execute();
  $res = $request->fetchAll(PDO::FETCH_ASSOC);
  $res = $res[0];

  $res = array("entree" => $res);
  $res = array(
      "http_status" => 200,
      "response" => "OK",
      "result" => $res
  );

  http_response_code(200);
  return json_encode($res);
}

function createOne($pdo, $input){
  if(!isset($input->id_aliment) ||
      !isset($input->id_user) ||
      !isset($input->date) ||
      strlen($input->date) <19 ||
      !isset($input->quantite)
  ){
    echo 'Erreur : Il manque au moins un paramètre.';
    http_response_code(400);
    exit(1);
  }

  try{
    $request = $pdo->prepare("
      INSERT INTO ALIMENT_CONSOMME (ID_REPAS, ID_ALIMENT_FK, ID_USER_FK, `DATE`, QUANTITE)
      VALUES (NULL, {$input->id_aliment}, {$input->id_user}, '{$input->date}', {$input->quantite})
    ");
    $request->execute();

    $last_id = $pdo->lastInsertId();
    $res = array("id" => $last_id);
    $res = array(
        "http_status" => 201,
        "response" => "Entrée insérée avec succès.",
        "result" => $res
    );

    http_response_code(201);
    return json_encode($res);
  }catch(PDOException $erreur){
    echo 'Erreur : '.$erreur->getMessage();
    http_response_code(500);
    return "";
  }
}

function updateOne($pdo, $id, $input){
  try{
    $request_string = "UPDATE ALIMENT_CONSOMME SET ";

    $res = array();
    if(isset($input->id_aliment)){
      $request_string .= " ID_ALIMENT_FK = {$input->id_aliment},";
      $res[] = "id_aliment=".$input->id_aliment;
    }
    if(isset($input->id_user)){
      $request_string .= " ID_USER_FK = {$input->id_user},";
      $res[] = "id_user=".$input->id_user;
    }
    if(isset($input->date)){
      $request_string .= " `DATE` = '{$input->date}',";
      $res[] = "date=".$input->date;
    }
    if(isset($input->quantite)){
      $request_string .= " QUANTITE= {$input->quantite},";
      $res[] = "quantite=".$input->quantite;
    }
    $request_string = substr($request_string,0,strlen($request_string)-1);
    $request_string .= " WHERE ID_REPAS = {$id}";

    $request = $pdo->prepare($request_string);
    $request->execute();
    $res = array(
        "http_status" => 202,
        "response" => "Entrée mise à jour avec succès.",
        "result" => $res
    );

    http_response_code(202);
    return json_encode($res);
  }catch(PDOException $erreur){
    echo 'Erreur : '.$erreur->getMessage();
    http_response_code(500);
  }
}

function deleteOne($pdo, $id){
  try{
    $request = $pdo->prepare("DELETE FROM ALIMENT_CONSOMME WHERE ID_REPAS = {$id}");
    $request->execute();

    $res = array("id" => $id);
    $res = array(
        "http_status" => 202,
        "response" => "Entrée supprimée avec succès.",
        "result" => $res
    );
    http_response_code(202);
    return json_encode($res);
  }catch(PDOException $err){
    echo 'Erreur : '.$err->getMessage();
    http_response_code(500);
  }
}
