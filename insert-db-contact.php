<?php

require "config-server.php";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("INSERT INTO contacts (first_name, last_name, phone_number) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $_POST['first_name'], $_POST['last_name'], $_POST['phone_number']);
$stmt->execute();

$stmt->close();

$mysqli->close();

echo "<script>alert('Contact added!'); location='index.phtml';</script>";

