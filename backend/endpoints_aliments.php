<?php
  function getAll($pdo){
      $request = $pdo->prepare(
        "SELECT A.ID_ALIMENT AS id, A.NOM_ALIMENT AS nom, A.ISLIQUID AS is_liquid, A.INDICE_NOVA AS indice_nova,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 1 THEN C.POUR_100G ELSE 0 END), 2) AS energie_kcal,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 2 THEN C.POUR_100G ELSE 0 END), 2) AS sel,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 3 THEN C.POUR_100G ELSE 0 END), 2) AS sucre,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 4 THEN C.POUR_100G ELSE 0 END), 2) AS proteines,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 5 THEN C.POUR_100G ELSE 0 END), 2) AS fibre_alimentaire,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 6 THEN C.POUR_100G ELSE 0 END), 2) AS matieres_grasses,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 7 THEN C.POUR_100G ELSE 0 END), 2) AS alcool
         FROM ALIMENTS AS A
         INNER JOIN EST_COMPOSE AS C
         ON C.ID_ALIMENT_FK = A.ID_ALIMENT
         INNER JOIN NUTRIMENTS AS N
         ON C.ID_NUTRIMENT_FK = N.ID_NUTRIMENT
         GROUP BY A.ID_ALIMENT"
      );

      $request->execute();
      $res = $request->fetchAll(PDO::FETCH_ASSOC);
      $res = array("aliments" => $res);

      $res = array(
        "http_status" => 200,
        "response" => "OK",
        "result" => $res
      );

      http_response_code(200);
      echo json_encode($res);
  }

  function getOne($pdo, $id){
      $request = $pdo->prepare(
        "SELECT A.ID_ALIMENT AS id, A.NOM_ALIMENT AS nom, A.ISLIQUID AS is_liquid, A.INDICE_NOVA AS indice_nova,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 1 THEN C.POUR_100G ELSE 0 END), 2) AS energie_kcal,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 2 THEN C.POUR_100G ELSE 0 END), 2) AS sel,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 3 THEN C.POUR_100G ELSE 0 END), 2) AS sucre,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 4 THEN C.POUR_100G ELSE 0 END), 2) AS proteines,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 5 THEN C.POUR_100G ELSE 0 END), 2) AS fibre_alimentaire,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 6 THEN C.POUR_100G ELSE 0 END), 2) AS matieres_grasses,
                ROUND(SUM(CASE WHEN C.ID_NUTRIMENT_FK = 7 THEN C.POUR_100G ELSE 0 END), 2) AS alcool
         FROM ALIMENTS AS A
         INNER JOIN EST_COMPOSE AS C
         ON C.ID_ALIMENT_FK = A.ID_ALIMENT
         INNER JOIN NUTRIMENTS AS N
         ON C.ID_NUTRIMENT_FK = N.ID_NUTRIMENT
         WHERE A.ID_ALIMENT = {$id}
         GROUP BY A.ID_ALIMENT"
      );
      $request->execute();
      $res = $request->fetchAll(PDO::FETCH_ASSOC);

      $res = array("aliment" => $res[0]);

      $res = array(
        "http_status" => 200,
        "response" => "OK",
        "result" => $res
      );

      http_response_code(200);
      echo json_encode($res);
  }

  function createOne($pdo, $input){
      if(!isset($input->nom) ||
         !isset($input->is_liquid) ||
         !isset($input->indice_nova) ||
         !isset($input->energie_kcal) ||
         !isset($input->sel) ||
         !isset($input->sucre) ||
         !isset($input->proteines) ||
         !isset($input->fibre_alimentaire) ||
         !isset($input->alcool) ||
         !isset($input->matieres_grasses) ||
         !isset($input->ingredient_de)
      ){
        echo 'Erreur : Il manque au moins un paramètre.';
        http_response_code(400);
        exit(1);
      }

      try{
        $request = $pdo->prepare(
          "INSERT INTO ALIMENTS (ID_ALIMENT, INDICE_NOVA, NOM_ALIMENT, ISLIQUID)
           VALUES (NULL, {$input->indice_nova}, ?, {$input->is_liquid})"
        );
        $request->bindParam(1, $input->nom, PDO::PARAM_STR);
        $request->execute();

        $last_id = $pdo->lastInsertId();

        $request = $pdo->prepare(
          "INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 1, {$last_id}, {$input->energie_kcal} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 2, {$last_id}, {$input->sel} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 3, {$last_id}, {$input->sucre} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 4, {$last_id}, {$input->proteines} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 5, {$last_id}, {$input->fibre_alimentaire} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 6, {$last_id}, {$input->matieres_grasses} );
           INSERT INTO EST_COMPOSE (ID_NUTRIMENT_FK, ID_ALIMENT_FK, POUR_100G)
           VALUES ( 7, {$last_id}, {$input->alcool} );"
        );
        $request->execute();

        foreach ($input->ingredient_de as $value) {
          if(!isset($value->id) || !isset($value->pourcentage_ingredient))
            continue;
            
          $request = $pdo->prepare(
            "INSERT INTO COMPOSITION (ID_COMPOSANT_FK, ID_ALIMENT_FK, POURCENTAGE)
             VALUES ({$last_id}, {$value->id}, {$value->pourcentage_ingredient})"
          );
          $request->execute();
        }

        $res = array("id" => $last_id);
        $res = array(
          "http_status" => 201,
          "response" => "Aliment inséré avec succès.",
          "result" => $res
        );

        http_response_code(201);
        echo json_encode($res);
      }catch(PDOException $erreur){
        echo 'Erreur : '.$erreur->getMessage();
        http_response_code(500);
      }
  }
  //
  // function updateUser($pdo, $user, $input){
  //     if(!isset($input->name) || !isset($input->email)){
  //       echo 'Erreur : Il manque au moins un paramètre.';
  //       http_response_code(400);
  //     }else{
  //       try{
  //         $request = $pdo->prepare("UPDATE users SET name='{$input->name}', email='{$input->email}' WHERE id='{$user}'");
  //
  //         if(!$request->execute()){
  //           echo 'Erreur : Aucun utilisateur avec cet id.';
  //           http_response_code(400);
  //         }else{
  //           echo "\nSuccessfully updated user {$user}\n";
  //           http_response_code(202);
  //         }
  //       }catch(Exception $err){
  //         echo 'Erreur : '.$err->getMessage();
  //         http_response_code(500);
  //       }
  //     }
  // }
  //
  function deleteOne($pdo, $id){
      try{
        $request = $pdo->prepare("DELETE FROM ALIMENTS WHERE ID_ALIMENT={$id}");

        if(!$request->execute()){
          echo 'Erreur : Aucun aliment avec cet id.';
          http_response_code(400);
        }else{
          $res = array("id" => $id);
          $res = array(
            "http_status" => 202,
            "response" => "Aliment supprimé avec succès.",
            "result" => $res
          );
          http_response_code(202);
          echo json_encode($res);
        }
      }catch(Exception $err){
        echo 'Erreur : '.$err->getMessage();
        http_response_code(500);
      }
  }
?>
