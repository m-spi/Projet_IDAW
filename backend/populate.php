<?php
  require_once('init_pdo.php');

  $data = array(
    (object) [
      'name' => 'eau cristaline',
      'code' => '3274080005003',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'coca',
      'code' => '5449000000439',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'IceTea',
      'code' => '3228886048436',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Fanta',
      'code' => '5449000052179',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Orangina',
      'code' => '3249760000654',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Hépar',
      'code' => '7613035974685',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Perrier',
      'code' => '7613035833272',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Salveta',
      'code' => '3068320123264',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Oasis',
      'code' => '3124480191182',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Tomate cerise',
      'code' => '3504182920011',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Laitue',
      'code' => '3270190021865',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Pain de mie blanc',
      'code' => '3228857000838',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Pain de mie complet',
      'code' => '3228857000906',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Nutella',
      'code' => '3017620422003',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'chocolat noir 70%',
      'code' => '3046920022651',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'flocons d\'avoine',
      'code' => '3229820019307',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Oreo',
      'code' => '7622300744663',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'velouté yahourt',
      'code' => '3033491579950',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'jus d\'orange',
      'code' => '3502110009449',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Bière 1664',
      'code' => '3080216052885',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'Desperados',
      'code' => '3119783007483',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'leffe blonde',
      'code' => '5410228142218',
      'isLiquid' => 1
    ],
    (object) [
      'name' => 'yahourt nature',
      'code' => '3033490004521',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'pringles nature',
      'code' => '5053990156009',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'chocolat milka',
      'code' => '3045140105502',
      'isLiquid' => 0
    ],
    (object) [
      'name' => 'Chips nature lay\'s',
      'code' => '3168930008958',
      'isLiquid' => 0
    ]
  );

  foreach ($data as $oneElement) {
    $resp = json_decode(file_get_contents("https://world.openfoodfacts.net/api/v2/product/".$oneElement->code))->product;

    $isLiquid = $oneElement->isLiquid;
    $name = $oneElement->name;

    echo "\n".$name."\n";

    $nova = $resp->nutriments->{'nova-group'};
    if(!isset($nova)) $nova = 'null';

    $nutriments = array(
      'energie_kcal' => $resp->nutriments->{'energy-kcal_100g'},
      'alcool' => $resp->nutriments->alcohol_100g,
      'sucre' => $resp->nutriments->sugars_100g,
      'sel' => $resp->nutriments->salt_100g,
      'fibre_alimentaire' => $resp->nutriments->fiber_100g,
      'proteines' => $resp->nutriments->proteins_100g,
      'matieres_grasses' => $resp->nutriments->{'saturated-fat_100g'}
    );

    if(!isset($nutriments['energie_kcal'])){
      echo "Pas de valeur pour 100g !\n";;
      continue;
    }

    foreach ($nutriments as $key => $value)
      if(!isset($value)) $nutriments[$key] = 0;

    try{
      $request = $pdo->prepare("INSERT INTO ALIMENTS (
        INDICE_NOVA, NOM_ALIMENT, ISLIQUID
      ) VALUES(
        {$nova}, ?, {$isLiquid}
      );");
      $request->bindParam(1, $name, PDO::PARAM_STR);

      $request->execute();
      $id = $pdo->lastInsertId();

      // energie_kcal
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        1, {$id}, {$nutriments['energie_kcal']}
      );");
      $request->execute();
      // sel
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        2, {$id}, {$nutriments['sel']}
        $request->execute();
      );");
      // sucre
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        3, {$id}, {$nutriments['sucre']}
      );");
      $request->execute();
      // proteines
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        4, {$id}, {$nutriments['proteines']}
      );");
      $request->execute();
      // fibre_alimentaire
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        5, {$id}, {$nutriments['fibre_alimentaire']}
      );");
      $request->execute();
      // matieres_grasses
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        6, {$id}, {$nutriments['matieres_grasses']}
      );");
      $request->execute();
      // alcool
      $request = $pdo->prepare("INSERT INTO EST_COMPOSE (
        ID_NUTRIMENT_FK, ID_ALIMENT_FK, POURCENTAGE
      ) VALUES(
        7, {$id}, {$nutriments['alcool']}
      );");
      $request->execute();
    }catch(PDOException $erreur){
      print_r($erreur);
    }
  }

  /*** close the database connection ***/
  // $pdo = null;
?>
