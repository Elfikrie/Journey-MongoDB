<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("aACcess-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content_Type, Access-Control-Allow-Headers, Authorization, X-Requested-with");

// include databse file
include_once "mongodb_config.php";

$dbname = "toko";
$collection = "barang";

//  DB Connection
$db = new DbManager();
$conn = $db->getConnection();

// record to update
$data = json_decode(file_get_contents("php://input", true));

$fields = $data->{'fields'};

$set_values = array();

foreach ($fields as $key => $fields) {
    $arr = (array)$fields;
    foreach($fields as $key => $value) {
        $set_values[$key] = $value;
    }
}

// _id field value
$id = $data->{'where'};

// update record
$update = new MongoDB\Driver\BulkWrite();
$update->update(
    ['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $set_values], ['multi' => false, 'upsert' => false]
);

$result = $conn->executeBulkWrite("$dbname.$collection", $update);

// verify
if ($result->getModifiedCount() == 1) {
    echo json_encode(
        array("message" => "Record Successfully updated")
    );
} else {
    echo json_encode(
        array("message" => "Error while updating record")
    );
}


?>