<?php
  function getAll($pdo){
    $request = $pdo->prepare("
        SELECT ID_USER AS id,
               EMAIL AS email,
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
        !isset($input->nom) ||
        strlen($input->nom) <1 ||
        !isset($input->age) ||
        !isset($input->is_male) ||
        !isset($input->poids) ||
        !isset($input->taille) ||
        !isset($input->sport)
    ){
      echo 'Erreur : Il manque au moins un paramètre.';
      http_response_code(400);
      exit(1);
    }

    try{
      $request = $pdo->prepare("
        INSERT INTO USER (ID_USER, EMAIL, NOM, PRENOM, AGE, ISMALE, POIDS, TAILLE, SPORT)
        VALUES (NULL, '{$input->email}', '{$input->nom}',"
                .(isset($input->prenom) ? "'{$input->prenom}'" : "NULL").",
                {$input->age}, {$input->is_male},
                {$input->poids}, {$input->taille},
                {$input->sport})
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
      $request_string = "UPDATE USER SET ";

      $res = array();
      if(isset($input->email)){
        $request_string .= " EMAIL = '{$input->email}',";
        $res[] = "email=".$input->email;
      }
      if(isset($input->nom)){
        $request_string .= " NOM = '{$input->nom}',";
        $res[] = "nom=".$input->nom;
      }
      if(isset($input->prenom)){
        $request_string .= " PRENOM = '{$input->prenom}',";
        $res[] = "prenom=".$input->prenom;
      }
      if(isset($input->age)){
        $request_string .= " AGE = {$input->age},";
        $res[] = "age=".$input->age;
      }
      if(isset($input->is_male)){
        $request_string .= " ISMALE = {$input->is_male},";
        $res[] = "is_male=".$input->is_male;
      }
      if(isset($input->poids)){
        $request_string .= " POIDS = {$input->poids},";
        $res[] = "poids=".$input->poids;
      }
      if(isset($input->taille)){
        $request_string .= " TAILLE = {$input->taille},";
        $res[] = "taille=".$input->taille;
      }
      if(isset($input->sport)){
        $request_string .= " SPORT = {$input->sport},";
        $res[] = "sport=".$input->sport;
      }
      $request_string = substr($request_string,0,strlen($request_string)-1);
      $request_string .= " WHERE ID_USER = {$id}";

      $request = $pdo->prepare($request_string);
      $request->execute();
      $res = array(
          "http_status" => 202,
          "response" => "Utilisateur mis à jour avec succès.",
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
      $request = $pdo->prepare("DELETE FROM USER WHERE ID_USER = {$id}");
      $request->execute();

      $res = array("id" => $id);
      $res = array(
          "http_status" => 202,
          "response" => "Utilisateur supprimé avec succès.",
          "result" => $res
      );
      http_response_code(202);
      return json_encode($res);
    }catch(PDOException $err){
      echo 'Erreur : '.$err->getMessage();
      http_response_code(500);
    }
  }
