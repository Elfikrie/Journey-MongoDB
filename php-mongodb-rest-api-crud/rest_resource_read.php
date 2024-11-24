<?php

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include dababase file
include_once 'mongodb_config.php';

$dbname = 'toko';
$collection = 'barang';

// Db connection
$db = new DbManager();
$conn = $db->getConnection();

// read all records
$filter = [];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

// fetch records
$records = $conn->executeQuery("$dbname.$collection", $read);

echo json_encode(iterator_to_array($records));



?>