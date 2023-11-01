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

      echo json_encode($res);
  }

  // function createUser($pdo, $input){
  //     if(!isset($input->name) || !isset($input->email)){
  //       echo 'Erreur : Il manque au moins un paramètre.';
  //       http_response_code(400);
  //     }else{
  //       try{
  //         if(isset($input->name) && isset($input->email)){
  //           $name = $input->name;
  //           $email = $input->email;
  //
  //           try{
  //             $request = $pdo->prepare("INSERT INTO users (id, name, email) VALUES (NULL, '{$name}', '{$email}')");
  //             $request->execute();
  //             echo "\nSuccessfully created user {$pdo->lastInsertId()}\n";
  //             http_response_code(201);
  //           }catch(PDOException $erreur){
  //             echo 'Erreur : '.$erreur->getMessage();
  //             http_response_code(500);
  //           }
  //         }
  //
  //         else{
  //           echo 'Veuillez envoyer un nom et une adresse mail valide.';
  //           http_response_code(400);
  //         }
  //       }catch(ErrorException $err){
  //         echo 'Erreur : '.$err->getMessage();
  //         http_response_code(500);
  //       }
  //     }
  // }
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
  // function deleteUser($pdo, $user){
  //     try{
  //       $request = $pdo->prepare("DELETE FROM users WHERE id='{$user}'");
  //
  //       if(!$request->execute()){
  //         echo 'Erreur : Aucun utilisateur avec cette id.';
  //         http_response_code(400);
  //       }else{
  //         echo 'Successfully deleted user {$user}';
  //         http_response_code(202);
  //       }
  //     }catch(Exception $err){
  //       echo 'Erreur : '.$err->getMessage();
  //       http_response_code(500);
  //     }
  // }
?>
