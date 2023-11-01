<?php
  require_once('init_pdo.php');
  require_once('endpoints_aliments.php');

  header("Access-Control-Allow-Origin: *");
  // header("Access-Control-Allow-Methods: *");
  header("Content-Type: application/json; charset=UTF-8");

  switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
      if($id = getID())
        getOne($pdo, $id);
      else
        getAll($pdo);

      break;

    /*case 'POST':
      checkCT();

      $input = json_decode(file_get_contents('php://input'));
      createUser($pdo, $input);

      break;

    case 'PUT':
      checkCT();

      $uri = explode('/', $_SERVER['REQUEST_URI']);
      $user = $uri[5];
      $input = json_decode(file_get_contents('php://input'));
      updateUser($pdo, $user, $input);

      break;

    case 'DELETE':
      $uri = explode('/', $_SERVER['REQUEST_URI']);
      $user = $uri[5];
      deleteUser($pdo, $user);

      break;*/

    default:
      exit(1);
  }

  $pdo = null;

  function getID(){
    $uri = $_SERVER['REQUEST_URI'];
    $id = substr($uri, strrpos($uri, '/')+1);
    if(strlen($id) == 0)
      return false;
    elseif($id[0] == 'a')
      return false;
    else
      return $id;
  }

  // Check if the input Content-Type is application/json
  // function checkCT(){
  //     if(str_contains($_SERVER["SERVER_SOFTWARE"], 'Apache') ||
  //        str_contains($_SERVER["SERVER_SOFTWARE"], 'apache') ||
  //        str_contains($_SERVER["SERVER_SOFTWARE"], 'APACHE')
  //     ){
  //       $headers = apache_request_headers();
  //       $h = $headers['Content-Type'];
  //       if(!str_contains($h, 'application/json')){
  //         echo 'Erreur : Mauvais Content-Type dans le request header.';
  //         http_response_code(400);
  //         exit(1);
  //       }
  //     }else{
  //       if(!str_contains($_SERVER['HTTP_CONTENT_TYPE'], 'application/json')){
  //         echo 'Erreur : Mauvais Content-Type dans le request header.';
  //         http_response_code(400);
  //         exit(1);
  //       }
  //     }
  // }
?>
