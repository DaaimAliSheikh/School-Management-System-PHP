<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database configuration
include('../includes/config.php');

// Ensure the request method is PATCH
if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}

// Parse the incoming PATCH data
parse_str(string: file_get_contents(filename: "php://input"), result: $patchData);

// Validate required fields
if (empty($patchData['serial']) || empty($patchData['title']) ) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing required fields.']);
    exit;
}


$id = mysqli_real_escape_string($db_conn, $patchData['serial']); 
$title = mysqli_real_escape_string($db_conn, $patchData['title']);

// Update the `accounts` table
$updateQuery = "UPDATE `sections` SET `title` = '$title' WHERE `id` = '$id'";
$result = mysqli_query($db_conn, $updateQuery);

// Check if the update was successful
if ($result) {
    if (mysqli_affected_rows($db_conn) > 0) {
        echo json_encode(['success' => 'section updated successfully.']);
    } else {
        echo json_encode(['info' => 'No changes were made to the section.']);
    }
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to update section.']);
}

exit;
