<?php
$mysqli = new mysqli("localhost", "root", "", "lms_plaida");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully to database lms_plaida";
?>
