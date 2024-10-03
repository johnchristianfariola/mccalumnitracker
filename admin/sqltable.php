<?php
try {
    // Establish database connection
    $conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u510162695_judging', 'u510162695_judging_root', '1Judging_root');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve all columns and rows from upcoming_events table
    $query = $conn->query("SELECT * FROM upcoming_events");

    // Check if there are any records in the table
    if ($query->rowCount() > 0) {
        // Start HTML table
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>";

        // Dynamically get column names from the result set
        for ($i = 0; $i < $query->columnCount(); $i++) {
            $columnMeta = $query->getColumnMeta($i);
            echo "<th>" . $columnMeta['name'] . "</th>";
        }
        
        // Add a header for the Delete button
        echo "<th>Action</th>";
        echo "</tr>";

        // Fetch and display each row
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($row as $column => $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }

            // Add the delete button with a link to delete.php passing the event_id
            echo "<td><a href='delete.php?event_id=" . $row['event_id'] . "' onclick='return confirm(\"Are you sure you want to delete this event?\")'>Delete</a></td>";
            echo "</tr>";
        }

        // End HTML table
        echo "</table>";
    } else {
        echo "No upcoming events found.";
    }
    
} catch (PDOException $e) {
    // Display error if the connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>
