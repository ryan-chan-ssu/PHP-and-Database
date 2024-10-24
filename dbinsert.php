<?php
$servername = "127.0.0.1:3306";
$username = "u768038663_db_RyanChan";
$password = "@ndu1nWry4nN";
$dbname = "u768038663_RyanChan";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$node = isset($_GET['node']) ? $_GET['node'] : null;
$temperature = isset($_GET['temperature']) ? $_GET['temperature'] : null;
$humidity = isset($_GET['humidity']) ? $_GET['humidity'] : null;
$light_level = isset($_GET['light_level']) ? $_GET['light_level'] : null;
$time_received = isset($_GET['time_received']) ? $_GET['time_received'] : null;

if ($node && $temperature && $humidity && $light_level) {
    $check_node = $conn->query("SELECT node_name FROM sensor_register WHERE node_name = '$node'");
    if ($check_node->num_rows > 0) {
        if ($temperature >= 100) {
            echo "Error: Temperature cannot be above 100.";
        } elseif ($humidity >= 65) {
            echo "Error: Humidity cannot be above 65.";
        } else {
            if ($time_received) {
                $insert_query = "INSERT INTO sensor_data (node_name, temperature, humidity, light_level, time_received) 
                                 VALUES ('$node', '$temperature', '$humidity', '$light_level', '$time_received')";
            } else {
                $insert_query = "INSERT INTO sensor_data (node_name, temperature, humidity, light_level, time_received) 
                                 VALUES ('$node', '$temperature', '$humidity', '$light_level', NOW())";
            }
            if ($conn->query($insert_query) === TRUE) {
                echo "Data successfully inserted.";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "'$node' is not registered.";
    }
} else {
    echo "Missing required parameters.";
}

// Close connection
$conn->close();
?>
