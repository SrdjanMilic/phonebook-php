<?php

class TableRows extends RecursiveIteratorIterator
{
    public function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    public function current()
    {
        return "<td>" . parent::current() . "</td>";
    }

    public function beginChildren()
    {
        echo "<tr>";
    }

    public function endChildren()
    {
        echo "</tr>" . "\n";
    }
}

require "config-server.php";

try {
    $search_value = $_POST["search"];
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE first_name = :keyword OR last_name = :keyword OR phone_number = :keyword");
    $stmt->bindParam(':keyword', $search_value);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<table class='table table-condensed table-bordered table-hover'>
        <thead><tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Phone Number</th></tr></thead>";
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
            echo $v;
        }
    } else {
        echo "<br><p style='padding-left: 22px;'>Sorry! There is no such contact in the database.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

$conn = null;

echo "</table>";
