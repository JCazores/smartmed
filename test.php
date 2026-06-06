<?php
require_once('initialize.php');
echo "DB_SERVER constant: " . DB_SERVER . "<br>";
echo "DB_PORT constant: " . DB_PORT . "<br>";

$conn = new mysqli();
$conn->real_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

if ($conn->connect_error) {
    echo "Error: " . $conn->connect_error;
} else {
    echo "Connected successfully!";
}
?>