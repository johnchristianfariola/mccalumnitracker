<?php
// Database connection details
$mysqlHost = "127.0.0.1";
$mysqlUsername = "u510162695_fms_db_root";
$mysqlPassword = "1Fms_db_root";
$mysqlDatabase = "u510162695_fms_db";

// Create a connection to the MySQL database
$conn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete record if 'delete_id' is set in the URL
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM applicant WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "Record with ID $deleteId deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// Fetch records from the applicant table
$query = "SELECT * FROM applicant";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Unique ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Sex</th>
            <th>Date of Birth</th>
            <th>Occupation</th>
            <th>ID Number</th>
            <th>Year Graduated</th>
            <th>School Graduated</th>
            <th>Program Graduated</th>
            <th>Admission</th>
            <th>Is Verified</th>
            <th>Alumni ID</th>
            <th>Action</th>
          </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['unique_id'] . "</td>
                <td>" . $row['fullname'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['contact'] . "</td>
                <td>" . $row['address'] . "</td>
                <td>" . $row['sex'] . "</td>
                <td>" . $row['dob'] . "</td>
                <td>" . $row['occupation'] . "</td>
                <td>" . $row['id_number'] . "</td>
                <td>" . $row['year_graduated'] . "</td>
                <td>" . $row['school_graduated'] . "</td>
                <td>" . $row['program_graduated'] . "</td>
                <td>" . $row['admission'] . "</td>
                <td>" . ($row['is_verified'] ? 'Yes' : 'No') . "</td>
                <td>" . $row['alumni_id'] . "</td>
                <td><a href='?delete_id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>