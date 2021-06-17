<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Credit.php';

  $database = new Database();
  $db = $database->connect();

  $credit = new Credit($db);

  $credit->id = isset($_GET['id']) ? $_GET['id'] : die();

  $credit->read_single();

  $credit_arr = array(
    'id' => $credit->id,
    'text' => $credit->text,
    'config' => $credit->config,
  );

  print_r(json_encode($credit_arr));