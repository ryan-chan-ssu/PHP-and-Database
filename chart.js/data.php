<?php
//setting header to json
header('Content-Type: application/json');

//database
define('DB_HOST', '127.0.0.1:3306');
define('DB_USERNAME', 'u768038663_db_RyanChan');
define('DB_PASSWORD', '@ndu1nWry4nN');
define('DB_NAME', 'u768038663_RyanChan');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("SELECT node_name, time_received, temperature, humidity, light_level FROM sensor_data");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//close connection
$mysqli->close();

//now print the data
print json_encode($data);