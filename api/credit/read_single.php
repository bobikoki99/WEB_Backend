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
  
    $credit->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $credit->read_single();
  
    $credit_arr = array(
      'id' => $credit->id,
      'text' => $credit->text,
      'config' => htmlspecialchars_decode($credit->config),
      'isPrivate' => $credit->isPrivate,
      'title' => $credit->title,
    );
  
    print_r(json_encode($credit_arr));
  } else {
    echo json_encode(
      array('message' => 'Yes')
    );
  }

