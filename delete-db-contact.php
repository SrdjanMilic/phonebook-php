<?php

require "config-server.php";

try {
    $id_value = $_POST["id"];
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = :user_input");
    $stmt->bindParam(':user_input', $id_value);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Record Id=$id_value deleted successfully!'); location='delete-contact.phtml';</script>";
    } else {
        echo "<script>alert('There is no such record!'); location='delete-contact.phtml';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<script>alert('Error: ' . $e->getMessage()); location='index.phtml';</script>";
}

$conn = null;
