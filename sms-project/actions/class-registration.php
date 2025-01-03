<?php 

include('../includes/config.php');
if(isset($_POST['title']) && isset($_POST['sections'])){
    $current_date = date('Y-m-d');
    $title = isset($_POST['title'])?$_POST['title']:'';
    $sections = isset($_POST['sections'])?$_POST['sections']:'';
    mysqli_query($db_conn, "INSERT INTO classes (`title`, `section`, `added_date`) VALUES ('$title', '$sections', '$current_date')") or die(mysqli_error($db_conn));
    die;
}
?>