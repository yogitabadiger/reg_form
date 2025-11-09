<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM students WHERE id=$id");
    echo "<script>alert('Record deleted successfully'); window.location.href='student.php';</script>";
}
$conn->close();
?>
