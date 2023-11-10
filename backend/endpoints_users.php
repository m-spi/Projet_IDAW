<?php
function getAll($pdo){
    $request = $pdo->prepare("
        SELECT ID_USER AS id,
               EMAIL AS email,
               PASSWORD as password,
               NOM AS nom,
               PRENOM AS prenom,
               AGE as age,
               ISMALE as is_male,
               POIDS as poids,
               TAILLE as taille,
               SPORT as sport
        FROM USER
        ORDER BY EMAIL
    ");

    $request->execute();
    $res = $request->fetchAll(PDO::FETCH_ASSOC);
    if(sizeof($res) == 0)
      getNotFound();

    $res = array("utilisateurs" => $res);
    $res = array(
        "http_status" => 200,
        "response" => "OK",
        "result" => $res
    );

    http_response_code(200);
    return json_encode($res);
}

function getOne($pdo, $id){
    $request = $pdo->prepare("
        SELECT ID_USER AS id,
               EMAIL AS email,
               PASSWORD as password,
               NOM AS nom,
               PRENOM AS prenom,
               AGE as age,
               ISMALE as is_male,
               POIDS as poids,
               TAILLE as taille,
               SPORT as sport
        FROM USER
        WHERE ID_USER = {$id}
    ");
    $request->execute();
    $res = $request->fetchAll(PDO::FETCH_ASSOC);
    if(sizeof($res) == 0)
      getNotFound();
    $res = $res[0];

    $res = array("utilisateur" => $res);
    $res = array(
        "http_status" => 200,
        "response" => "OK",
        "result" => $res
    );

    http_response_code(200);
    return json_encode($res);
}

function createOne($pdo, $input){
    if(!isset($input->email) ||
        strlen($input->email) <1 ||
        !isset($input->password) ||
        strlen($input->password) <1 ||
        !isset($input->nom) ||
        strlen($input->nom) <1 ||
        !isset($input->age) ||
        !isset($input->is_male) ||
        !isset($input->poids) ||
        !isset($input->taille) ||
        !isset($input->sport)
    ){
      $res = array(
          "http_status" => 400,
          "response" => "Erreur : Il manque au moins un paramètre."
      );

      http_response_code(400);
      echo json_encode($res);
      exit(1);
    }

    try{
      $request = $pdo->prepare("
        INSERT INTO USER (ID_USER, EMAIL, PASSWORD, NOM, PRENOM, AGE, ISMALE, POIDS, TAILLE, SPORT)
        VALUES (NULL,'{$input->email}','{$input->password}','{$input->nom}',".(isset($input->prenom) ? "'{$input->prenom}'" : "NULL").",{$input->age},{$input->is_male},{$input->poids},{$input->taille},{$input->sport})");
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
      $request_string = "UPDATE USER SET ";

      $res = array();
      $no_request = true;
      if(isset($input->email)){
        $no_request = false;
        if(strlen($input->email) == 0)
          inputError('Email de taille 0');

        $request_string .= " EMAIL = '{$input->email}',";
        $res[] = "email=".$input->email;
      }
      if(isset($input->password)){
        $no_request = false;
        if(strlen($input->password) == 0)
          inputError('Mot de passe de taille 0');

        $request_string .= " PASSWORD = '{$input->password}',";
        $res[] = "password=".$input->password;
      }
      if(isset($input->nom)){
        $no_request = false;
        if(strlen($input->nom) == 0)
          inputError('Nom de taille 0');

        $request_string .= " NOM = '{$input->nom}',";
        $res[] = "nom=".$input->nom;
      }
      if(isset($input->prenom)){
        $no_request = false;
        $request_string .= " PRENOM = '{$input->prenom}',";
        $res[] = "prenom=".$input->prenom;
      }
      if(isset($input->age)){
        $no_request = false;
        $request_string .= " AGE = {$input->age},";
        $res[] = "age=".$input->age;
      }
      if(isset($input->is_male)){
        $no_request = false;
        $request_string .= " ISMALE = {$input->is_male},";
        $res[] = "is_male=".$input->is_male;
      }
      if(isset($input->poids)){
        $no_request = false;
        $request_string .= " POIDS = {$input->poids},";
        $res[] = "poids=".$input->poids;
      }
      if(isset($input->taille)){
        $no_request = false;
        $request_string .= " TAILLE = {$input->taille},";
        $res[] = "taille=".$input->taille;
      }
      if(isset($input->sport)){
        $no_request = false;
        $request_string .= " SPORT = {$input->sport},";
        $res[] = "sport=".$input->sport;
      }

      if(!$no_request){
        $request_string = substr($request_string, 0, strlen($request_string) - 1);
        $request_string .= " WHERE ID_USER = {$id}";

        $request = $pdo->prepare($request_string);
        $request->execute();
      }

      $res = array(
          "http_status" => 201,
          "response" => "Utilisateur mis à jour avec succès.",
          "result" => $res
      );

        http_response_code(201);
        return json_encode($res);
    }catch(PDOException $erreur){
      echo 'Erreur : '.$erreur->getMessage();
      http_response_code(500);
    }
}

function deleteOne($pdo, $id){
    try{
        $request = $pdo->prepare("DELETE FROM USER WHERE ID_USER = {$id}");

        if(!$request->execute())
          getNotFound();

        $res = array("id" => $id);
        $res = array(
            "http_status" => 200,
            "response" => "Utilisateur supprimé avec succès.",
            "result" => $res
        );
        http_response_code(200);
        return json_encode($res);
    }catch(PDOException $err){
        echo 'Erreur : '.$err->getMessage();
        http_response_code(500);
    }
}

function getNotFound(){
  $res = array(
      "http_status" => 404,
      "response" => "Erreur : Aucun utilisateur trouvé."
  );

  http_response_code(404);
  echo json_encode($res);
  exit(1);
}

function inputError($errorString){
  $res = array(
      "http_status" => 400,
      "response" => "Erreur : ".$errorString
  );

  http_response_code(400);
  echo json_encode($res);
  exit(1);
}