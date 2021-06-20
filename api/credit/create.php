<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Credit.php';

if ($_SERVER['REQUEST_METHOD'] != "OPTIONS") {
  $database = new Database();
  $db = $database->connect();

  $credit = new Credit($db);

  $data = json_decode(file_get_contents("php://input"));

  $options = [
    'salt' => 'XmLQmYLGR=e#d6xO=d@vsW',
  ];

  $credit->text = $data->text;
  $credit->title = $data->title;
  $credit->config =  json_encode($data->config);
  $credit->isPrivate = $data->isPrivate;
  $credit->password = password_hash($data->password, 1, $options);

  if ($credit->create()) {
    echo json_encode(
      array('id' => $credit->id)
    );
  } else {
    echo json_encode(
      array('message' => 'Credit Not Created')
    );
  }
} else {
  echo json_encode(
    array('message' => 'OPTIONS')
  );
}
