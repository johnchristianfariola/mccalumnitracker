<?php
header('Content-Type: application/json');

function getMySQLConnection() {
    $servername = "127.0.0.1";
    $username = "u510162695_fms_db_root";
    $password = "1Fms_db_root";
    $dbname = "u510162695_fms_db";



    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        return false;
    }
    return $conn;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $mysqlInsertData = [
        'unique_id' => $data['unique_id'],
        'id_number' => $data['id_number'],
        'fullname' => $data['fullname'],
        'email' => $data['email'],
        'contact' => $data['contact'],
        'sex' => $data['sex'],
        'dob' => $data['dob'],
        'year_graduated' => $data['year_graduated'],
        'admission' => $data['admission'],
        'program_graduated' => $data['program_graduated'],
        'is_verified' => 1,
        'password' => $data['password']
    ];

    try {
        $mysqlConn = getMySQLConnection();
        if (!$mysqlConn) {
            throw new Exception('Failed to connect to MySQL database.');
        }

        $mysqlQuery = "INSERT INTO applicant (" . implode(", ", array_keys($mysqlInsertData)) . ") VALUES ('" . implode("', '", array_map([$mysqlConn, 'real_escape_string'], array_values($mysqlInsertData))) . "')";
        $mysqlResult = $mysqlConn->query($mysqlQuery);
        if (!$mysqlResult) {
            throw new Exception('Failed to insert into MySQL database: ' . $mysqlConn->error);
        }
        $mysqlConn->close();

        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } catch (Exception $e) {
        error_log("Error updating profile: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile. Please try again.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>