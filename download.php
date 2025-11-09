<?php
include 'connect.php';
$id = $_GET['id'];
$res = $conn->query("SELECT document FROM students WHERE id='$id'");
if ($res && $row = $res->fetch_assoc()) {
  header("Content-type: application/pdf");
  echo $row['document'];
}
?>
