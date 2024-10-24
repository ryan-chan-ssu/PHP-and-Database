<?php
// Database connection parameters

$servername = "127.0.0.1:3306";
$username = "u768038663_db_RyanChan";
$password = "@ndu1nWry4nN";
$dbname = "u768038663_RyanChan";

try {
    // Create a PDO database connection
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // SQL query to retrieve data
    $query = "SELECT time_received, temperature FROM sensor_data WHERE node_name = 'node_6'";

    // Prepare and execute the query
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Fetch data into an array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $db = null;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Prepare data for Google Charts
$dataArray = [['Time Received', 'Temperature']];
foreach ($data as $row) {
    $dataArray[] = [$row['time_received'], (float) $row['temperature']];
}

// Convert data to JSON
$dataJson = json_encode($dataArray);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Temperature Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);

            var options = {
                title: 'Sensor node_1',
                vAxis: { title: 'Temperature' },
                hAxis: { title: 'Time', slantedText: true },
                series: {0: { pointSize: 6 }},
                curveType: 'function',
                colors: ['#9fdc36'],
                legend: { position: 'top' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div" style="width: 800px; height: 400px;"></div>
</body>
</html>
