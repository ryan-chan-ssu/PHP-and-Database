<!DOCTYPE html>
<html lang="en">
<head>
<title>Sensor Data</title>
<meta charset="utf-8">
<style>
    th {
        background-color: #ceff7b;
    }
</style>
</style>
</head>
<body>
    
<h1>Welcome to SSU IoT Lab</h1>
<h3>Registered Sensor Nodes</h3>

<?php
$servername = "127.0.0.1:3306";
$username = "u768038663_db_RyanChan";
$password = "@ndu1nWry4nN";
$dbname = "u768038663_RyanChan";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$sensor_register = $conn->query("SELECT node_name, manufacturer, longitude, latitude FROM sensor_register");
if ($sensor_register->num_rows > 0) {
    echo "<table border='1'><tr>";
    while ($field = $sensor_register->fetch_field()) echo "<th>{$field->name}</th>";
    echo "</tr>";
    while ($row = $sensor_register->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $cell) echo "<td>$cell</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found or table does not exist.";
}

echo "<h3>Data Received</h3>";
$sensor_data = $conn->query("SELECT node_name, time_received, temperature, humidity, light_level FROM sensor_data");
if ($sensor_data->num_rows > 0) {
    echo "<table border='1'><tr>";
    while ($field = $sensor_data->fetch_field()) echo "<th>{$field->name}</th>";
    echo "</tr>";
    while ($row = $sensor_data->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $cell) echo "<td>$cell</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found or table does not exist.";
}

$node = "node_6";
$avg_result = $conn->query("SELECT AVG(temperature) AS avg_temp, AVG(humidity) AS avg_humidity, AVG(light_level) AS avg_light_level FROM sensor_data WHERE node_name = '$node'");
if ($avg_result->num_rows > 0) {
    $avg_row = $avg_result->fetch_assoc();
    $average_temperature = number_format($avg_row["avg_temp"], 2);
    $average_humidity = number_format($avg_row["avg_humidity"], 2);
    $average_light_level = number_format($avg_row["avg_light_level"], 2);
    echo "<p>The Average Temperature for $node has been: $average_temperature °F</p>";
    echo "<p>The Average Humidity for $node has been: $average_humidity %</p>";
    echo "<p>The Average Light Level for $node has been: $average_light_level V</p>";
} else {
    echo "<p>No data available for $node.</p>";
}

$conn->close();
?>

<iframe src="chart.js/singleFilePlot.php" width="800" height="450" style="border:none;"></iframe>
    
</body>
</html>
