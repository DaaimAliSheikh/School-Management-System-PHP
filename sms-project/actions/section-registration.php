<?php 
include('../includes/config.php');
if(isset($_POST['title'])){
    $title = isset($_POST['title'])?$_POST['title']:'';
    mysqli_query($db_conn, "INSERT INTO sections (`title`) VALUES ('$title')") or die(mysqli_error($db_conn));
    die;
}
?>