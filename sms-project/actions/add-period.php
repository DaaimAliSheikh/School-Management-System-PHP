<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database configuration
include('../includes/config.php');

  $title = isset($_POST['title'])?$_POST['title']:'';
  $from = isset($_POST['from'])?$_POST['from']:'';
  $to = isset($_POST['to'])?$_POST['to']:'';
  $status = 'publish';
  $type = 'period';
  $parent = 0;
  $description = 'description';
  $date_add = date('Y-m-d g:i:s');

  $query = mysqli_query($db_conn, "INSERT INTO `posts` (`title`,`status`,`publish_date`,`type`, `parent`, `description`) VALUES ('$title','$status','$date_add','$type',  '$parent', '$description') ");
  if($query)
  {
    $item_id = mysqli_insert_id($db_conn);
  }

  mysqli_query($db_conn, "INSERT INTO `metadata` (`meta_key`,`meta_value`,`item_id`) VALUES ('from','$from','$item_id') ");
  mysqli_query($db_conn, "INSERT INTO `metadata` (`meta_key`,`meta_value`,`item_id`) VALUES ('to','$to','$item_id') ");


?>