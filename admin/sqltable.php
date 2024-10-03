<?php
try {
    $conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u510162695_judging', 'u510162695_judging_root', '1Judging_root');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve all tables in the database
    $query = $conn->query("SHOW TABLES");

    // Fetch and display each table
    echo "Tables in the database:<br>";
    while ($row = $query->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>