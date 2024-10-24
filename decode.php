<?php
// Get the query string parameters from the URL
if(isset($_GET['data'])) {
    // Retrieve the encoded string from the URL parameter
    $encodedData = $_GET['data'];

    // Decode the Base64 encoded string
    $decodedData = base64_decode($encodedData);
    
    parse_str($decodedData, $params);

    // Display the decoded data
    echo "Decoded Data: " . htmlspecialchars($decodedData). "<br><br>";
    foreach ($params as $key => $value) {
        echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
    }
} else {
    echo "No data received.";
}
?>
