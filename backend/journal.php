<?php
  require_once('init_pdo.php');
  require_once('endpoints_journal.php');

  header("Access-Control-Allow-Origin: *");
  // header("Access-Control-Allow-Methods: *");
  header("Content-Type: application/json; charset=UTF-8");

  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if ($id = getID())
        if(str_contains($_SERVER['REQUEST_URI'], 'user')){
          $json = getUserAll($pdo, $id);
        }else
          $json = getOne($pdo, $id);
      else
        $json = getAll($pdo);

      break;

    case 'POST':
      checkCT();

      $input = json_decode(file_get_contents('php://input'));
      $json = createOne($pdo, $input);

      break;

    case 'PUT':
      checkCT();

      $input = json_decode(file_get_contents('php://input'));
      if ($id = getID())
        $json = updateOne($pdo, $id, $input);
      else
        echo "Erreur : Veuillez spécifier l'id dans l'URL.";

      break;

    case 'DELETE':
      if ($id = getID())
        $json = deleteOne($pdo, $id);
      else
        echo "Erreur : Veuillez spécifier l'id dans l'URL.";

      break;

    default:
      exit(1);

  }

  echo $json;
  $pdo = null;

  function getID()
  {
    $uri = $_SERVER['REQUEST_URI'];
    $id = substr($uri, strrpos($uri, '/') + 1);

    if (strlen($id) == 0)
      return false;
    elseif (!is_numeric($id))
      return false;
    else
      return $id;
  }

  // Check if the input Content-Type is application/json
  function checkCT()
  {
    if (str_contains($_SERVER["SERVER_SOFTWARE"], 'Apache') ||
        str_contains($_SERVER["SERVER_SOFTWARE"], 'apache') ||
        str_contains($_SERVER["SERVER_SOFTWARE"], 'APACHE')
    ) {
      $headers = apache_request_headers();
      $h = $headers['Content-Type'];
      if (!str_contains($h, 'application/json')) {
        echo 'Erreur : Mauvais Content-Type dans le request header.';
        http_response_code(400);
        exit(1);
      }
    } else {
      if (!str_contains($_SERVER['HTTP_CONTENT_TYPE'], 'application/json')) {
        echo 'Erreur : Mauvais Content-Type dans le request header.';
        http_response_code(400);
        exit(1);
      }
    }
  }

