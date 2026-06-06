<?php
echo "DB_HOST env: " . getenv('DB_HOST') . "<br>";
echo "DB_PORT env: " . getenv('DB_PORT') . "<br>";
echo "Trying to connect to: acela.proxy.rlwy.net:58509<br>";

$conn = new mysqli();
$conn->real_connect('acela.proxy.rlwy.net', 'root', 'oCZnrPaBlUHwYSSosvPTWAFRnKiSwQJI', 'smart_med', 58509);

if ($conn->connect_error) {
    echo "Error: " . $conn->connect_error;
} else {
    echo "Connected successfully!";
}
?>