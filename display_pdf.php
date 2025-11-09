<?php
include 'connect.php';

if (!isset($_GET['id'])) {
  die("No ID provided.");
}

$id = intval($_GET['id']);
$query = "SELECT document FROM students WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $path = $row['document'];
  if (file_exists($path)) {
    header("Content-Type: application/pdf");
    readfile($path);
  } else {
    echo "PDF file missing.";
  }
} else {
  echo "No document found.";
}
?>
