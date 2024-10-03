<?php
try {
    // Establish database connection
    $conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u510162695_judging', 'u510162695_judging_root', '1Judging_root');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if 'event_id' is passed via URL
    if (isset($_GET['event_id'])) {
        $event_id = $_GET['event_id'];

        // Prepared statement to get the specific event by event_id
        $stmt = $conn->prepare("SELECT * FROM upcoming_events WHERE event_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if the event is found
        if ($stmt->rowCount() > 0) {
            // Fetch the event details
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Display the event details
            echo "<h2>Event Details</h2>";
            echo "Event ID: " . $event['event_id'] . "<br>";
            echo "Event Name: " . $event['event_name'] . "<br>";
            echo "Event Date: " . $event['event_date'] . "<br>";
            echo "Location: " . $event['location'] . "<br>";
            echo "Description: " . $event['description'] . "<br>";  // If there's a description field
        } else {
            echo "Event not found.";
        }
    } else {
        echo "No event ID specified.";
    }
    
} catch (PDOException $e) {
    // Display error if the connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>
