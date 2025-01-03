<?php 
include('../includes/config.php');
if(isset($_POST['name']) && isset($_POST['last_payment']) && isset($_POST['due_payment']) && isset($_POST['fee_status'])){
    $name = isset($_POST['name'])?$_POST['name']:'';
    $last_payment = isset($_POST['last_payment'])?$_POST['last_payment']:'';
    $due_payment = isset($_POST['due_payment'])?$_POST['due_payment']:'';
    $fee_status = isset($_POST['fee_status'])?$_POST['fee_status']:'';
    mysqli_query($db_conn, "INSERT INTO fee (`student_name`, `last_payment_date`, `due_payment`, `fee_status`) VALUES ('$name', '$last_payment', '$due_payment', '$fee_status')") or die(mysqli_error($db_conn));
    die;
}
?>