<?php
include 'connect.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
$students = [];
while ($row = $result->fetch_assoc()) {
    // For privacy, you might want to skip sending hashed passwords and binary files
    unset($row['password']);
    unset($row['photo']);
    unset($row['document']);
    $students[] = $row;
}
echo json_encode($students);

$conn->close();
?>
