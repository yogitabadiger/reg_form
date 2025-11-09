<?php
include 'connect.php';
if (!isset($_GET['id'])) {
  die("No ID provided.");
}
$id = intval($_GET['id']);
$query = "SELECT photo FROM students WHERE id = $id";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $path = $row['photo'];
  if (file_exists($path)) {
    header("Content-Type: image/jpeg");
    readfile($path);
  } else {
    echo "Image file missing.";
  }
} else {
  echo "Image not found.";
}
?>
