<?php
include 'connect.php';

$id = $_POST['id'];

$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$color = $_POST['color'];
$rollno = $_POST['rollno'];
$department = $_POST['department'];
$year = $_POST['year'];
$sem = $_POST['sem'];
$cgpa = $_POST['cgpa'];
$favsub = $_POST['favsub'];
$percentage = $_POST['percentage'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$pincode = $_POST['pincode'];
$linkedin = $_POST['linkedin'];
$github = $_POST['github'];
$hobbies = $_POST['hobbies'];
$skills = $_POST['skills'];
$languages = $_POST['languages'];

$sql = "UPDATE students SET 
fname='$fname', mname='$mname', lname='$lname', dob='$dob', gender='$gender', email='$email', password='$password', 
phone='$phone', color='$color', rollno='$rollno', department='$department', year='$year', sem='$sem', cgpa='$cgpa',
favsub='$favsub', percentage='$percentage', address='$address', city='$city', state='$state', pincode='$pincode',
linkedin='$linkedin', github='$github', hobbies='$hobbies', skills='$skills', languages='$languages'";

if (!empty($_FILES['photo']['tmp_name'])) {
    $photo = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
    $sql .= ", photo='$photo'";
}

if (!empty($_FILES['document']['tmp_name'])) {
    $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
    $sql .= ", document='$document'";
}

$sql .= " WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Student details updated successfully!'); window.location='student.php';</script>";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
