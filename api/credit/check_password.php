<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type');

  include_once '../../config/Database.php';
  include_once '../../models/Credit.php';

  if($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
    $database = new Database();
    $db = $database->connect();
  
    $credit = new Credit($db);
  
    $user_password = isset($_GET['pass']) ? $_GET['pass'] : die();
    $credit->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $credit->read_password();

    $options = [
        'salt' => 'XmLQmYLGR=e#d6xO=d@vsW',
      ];

    $hashed_user_password = password_hash($user_password, 1, $options);
  
    if ($credit->password == $hashed_user_password) {
        echo json_encode(
          array('isCorrect' => true)
        );
      } else {
        echo json_encode(
          array('isCorrect' => false)
        );
      }
  } else {
    echo json_encode(
      array('message' => 'Yes')
    );
  }

