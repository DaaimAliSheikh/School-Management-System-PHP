<?php
include('../includes/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $current_date = date('Y-m-d');
    $upload_dir = '../dist/uploads/'; // Directory to save uploaded images

    // Ensure the directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];

        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('img_') . '.' . $image_extension; // Generate unique name
      
        $target_file = $upload_dir . $image_name;

        // Validate the file type (only allow images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            // Move the uploaded file to the target directory
            
            if (move_uploaded_file($image_tmp, $target_file)) {
                // Save the image path to the database
                    mysqli_query($db_conn, "INSERT INTO courses (`name`, `category`, `duration`, `date`,`image`) VALUES ('$name', '$category', '$duration', '$current_date', '$target_file')") or die(mysqli_error($db_conn));

                    // Return the image path
                    echo json_encode(['success' => true, 'path' => $target_file]);

              
            } else {
                echo json_encode(['success' => false, 'message' => 'Error moving the uploaded file.'.$target_file.' and '.$image_tmp]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file' ]);
    }
} else {
    echo "<p>Invalid request method.</p>";
}

?>
