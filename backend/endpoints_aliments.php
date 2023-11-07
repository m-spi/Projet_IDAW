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
         GROUP BY A.ID_ALIMENT
         ORDER BY nom"
      );

      $request->execute();
      $res = $request->fetchAll(PDO::FETCH_ASSOC);

      $request = $pdo->prepare("
        SELECT ID_ALIMENT AS id_aliment, ID_ALIMENT_FK AS lien, '1' as is_ingredient
        FROM COMPOSITION
        JOIN ALIMENTS
        ON ID_ALIMENT = ID_COMPOSANT_FK
        UNION
        SELECT ID_ALIMENT AS id_aliment, ID_COMPOSANT_FK AS lien, '0' as is_ingredient
        FROM COMPOSITION
        JOIN ALIMENTS
        ON ID_ALIMENT = ID_ALIMENT_FK
        ORDER BY ID_ALIMENT
      ");
      $request->execute();
      $res_comp = $request->fetchAll(PDO::FETCH_ASSOC);

      for($i=0; $i<sizeof($res); $i++){
        $res[$i] = array_merge($res[$i], array(
            "ingredient_de" => array(),
            "compose_par" => array()
        ));
        $count_ingr = 0;
        $count_comp = 0;
        foreach($res_comp as $r){
          if($r['id_aliment'] != $res[$i]['id'])
            continue;
          if($r['is_ingredient'])
            $res[$i]['ingredient_de'][] = $r['lien'];
          else
            $res[$i]['compose_par'][] = $r['lien'];
        }
      }

      $res = array("aliments" => $res);
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
      $res = $res[0];

      $request = $pdo->prepare("
          SELECT ID_ALIMENT AS id_aliment, ID_ALIMENT_FK AS lien, '1' as is_ingredient
          FROM COMPOSITION
          JOIN ALIMENTS
          ON ID_ALIMENT = ID_COMPOSANT_FK
          WHERE ID_ALIMENT = {$id}
          UNION
          SELECT ID_ALIMENT AS id_aliment, ID_COMPOSANT_FK AS lien, '0' as is_ingredient
          FROM COMPOSITION
          JOIN ALIMENTS
          ON ID_ALIMENT = ID_ALIMENT_FK
          WHERE ID_ALIMENT = {$id}
          ORDER BY ID_ALIMENT
      ");
      $request->execute();
      $res_comp = $request->fetchAll(PDO::FETCH_ASSOC);

      $res = array_merge($res, array(
          "ingredient_de" => array(),
          "compose_par" => array()
      ));
      foreach($res_comp as $r){
        if($r['id_aliment'] != $res['id'])
          continue;
        if($r['is_ingredient'])
          $res['ingredient_de'][] = $r['lien'];
        else
          $res['compose_par'][] = $r['lien'];
      }

      $res = array("aliment" => $res);
      $res = array(
        "http_status" => 200,
        "response" => "OK",
        "result" => $res
      );

      http_response_code(200);
      return json_encode($res);
  }

  function createOne($pdo, $input){
      if(!isset($input->nom) ||
         strlen($input->nom) < 1 ||
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
          if($value->pourcentage_ingredient == 0)
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
        return json_encode($res);
      }catch(PDOException $erreur){
        echo 'Erreur : '.$erreur->getMessage();
        http_response_code(500);
      }
  }

  function addOneIngredient($pdo, $input){
    try{
      $request = $pdo->prepare(
        "INSERT INTO COMPOSITION (ID_COMPOSANT_FK, ID_ALIMENT_FK, POURCENTAGE)
         VALUES ({$input->id_ingredient}, {$input->id_aliment}, {$input->pourcentage_ingredient})"
      );
      $request->execute();

      $res = array(
        "http_status" => 202,
        "response" => "Ingrédient ajouté avec succès."
      );
      http_response_code(202);
      return json_encode($res);
    }catch(PDOException $erreur){
      echo 'Erreur : '.$erreur->getMessage();
      http_response_code(500);
    }
  }

  function updateOne($pdo, $id, $input){
      try{
        $request_string = "UPDATE EST_COMPOSE SET POUR_100G = (CASE ID_NUTRIMENT_FK";

        $res = array();
        $map = array(
            "energie_kcal",
            "sel",
            "sucre",
            "proteines",
            "fibre_alimentaire",
            "matiere_grasses",
            "alcool"
        );

        for($i=0; $i<7; $i++) {
          $key = $map[$i];
          if(isset($input->$key)) {
            $request_string .= ' WHEN '. $i+1 .' THEN '.$input->$key;
            $res[] = $key.'='.$input->$key;
          }else{
            $request_string .= ' WHEN '. $i+1 .' THEN POUR_100G';
          }
        }
        $request_string .= ' ELSE POUR_100G END) WHERE ID_ALIMENT_FK = '.$id;

        if(isset($input->ingredient_de)){
          $pdo->exec("DELETE FROM COMPOSITION WHERE ID_COMPOSANT_FK = {$id}");
          $r = "ingredient_de=[";
          foreach ($input->ingredient_de as $ingr){
            $ingr->id_ingredient = $id;
            addOneIngredient($pdo, $ingr);
            $r .= $ingr->id_aliment.", ";
          }
          $r .= "]";
          $res[] = $r;
        }
        if(isset($input->compose_par)){
          $pdo->exec("DELETE FROM COMPOSITION WHERE ID_ALIMENT_FK = {$id}");
          $r = "compose_par=[";
          foreach ($input->compose_par as $ingr){
            $ingr->id_aliment = $id;
            addOneIngredient($pdo, $ingr);
            $r .= $ingr->id_ingredient.", ";
          }
          $r .= "]";
          $res[] = $r;
        }

        if(isset($input->indice_nova) && isset($input->is_liquid)){
          $request_string .= "; UPDATE ALIMENTS SET 
                        INDICE_NOVA = {$input->indice_nova}, 
                        ISLIQUID = {$input->is_liquid} 
                    WHERE ID_ALIMENT = {$id}";
        }elseif (isset($input->indice_nova)){
          $request_string .= "; UPDATE ALIMENTS SET 
                        INDICE_NOVA = {$input->indice_nova} 
                    WHERE ID_ALIMENT = {$id}";
        }elseif (isset($input->is_liquid)){
          $request_string .= "; UPDATE ALIMENTS SET 
                        ISLIQUID = {$input->is_liquid} 
                    WHERE ID_ALIMENT = {$id}";
        }

        $request = $pdo->prepare($request_string);
        $request->execute();
        $res = array(
              "http_status" => 202,
              "response" => "Aliment mis à jour avec succès.",
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
          return json_encode($res);
        }
      }catch(Exception $err){
        echo 'Erreur : '.$err->getMessage();
        http_response_code(500);
      }
  }

  function deleteOneIngredient($pdo, $id_aliment, $id_ingredient){
      try{
        $request = $pdo->prepare("DELETE FROM COMPOSITION WHERE ID_ALIMENT_FK={$id_aliment} AND ID_COMPOSANT_FK={$id_ingredient}");

        if(!$request->execute()){
          echo 'Erreur : Cet ingrédient ne compose pas cet aliment (mauvaise paire d\'IDs).';
          http_response_code(400);
        }else{
          $res = array("id_aliment" => $id_aliment, "id_ingredient" => $id_ingredient);
          $res = array(
            "http_status" => 202,
            "response" => "Ingrédient supprimé avec succès.",
            "result" => $res
          );
          http_response_code(202);
          return json_encode($res);
        }
      }catch(Exception $err){
        echo 'Erreur : '.$err->getMessage();
        http_response_code(500);
      }
  }

