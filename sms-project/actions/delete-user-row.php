<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database configuration
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}

parse_str(file_get_contents("php://input"), $deleteData);

if (empty($deleteData['serial']) ) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing required fields.']);
    exit;
}

$id = mysqli_real_escape_string($db_conn, $deleteData['serial']); 

$deleteQuery = "DELETE FROM `accounts` WHERE `id` = '$id'";
$result = mysqli_query($db_conn, $deleteQuery);


if ($result) {
    if (mysqli_affected_rows($db_conn) > 0) {
        echo json_encode(['success' => 'User deleted successfully.']);
    } else {
        echo json_encode(['info' => 'No deletions were made.']);
    }
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to update user.']);
}

exit;