<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Credit.php';

  $database = new Database();
  $db = $database->connect();

  $credit = new Credit($db);

  $data = json_decode(file_get_contents("php://input"));

  $credit->text = $data->text;
  $credit->config = $data->config;

  if($credit->create()) {
    echo json_encode(
      array('message' => 'Credit Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Credit Not Created')
    );
  }

