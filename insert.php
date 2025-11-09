<?php
// insert.php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create uploads directory if it doesn't exist
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Sanitize inputs
    function clean($conn, $value) {
        return $conn->real_escape_string(trim($value ?? ''));
    }

    $fname = clean($conn, $_POST['fname']);
    $mname = clean($conn, $_POST['mname']);
    $lname = clean($conn, $_POST['lname']);
    $dob = $_POST['dob'] ?? '';
    $gender = clean($conn, $_POST['gender']);
    $email = clean($conn, $_POST['email']);
    $password = $_POST['password'] ?? '';
    $phone = clean($conn, $_POST['phone']);
    $color = clean($conn, $_POST['color']);
    $rollno = clean($conn, $_POST['rollno']);
    $department = clean($conn, $_POST['department']);
    $year = intval($_POST['year'] ?? 0);
    $sem = intval($_POST['sem'] ?? 0);
    $cgpa = floatval($_POST['cgpa'] ?? 0);
    $favsub = clean($conn, $_POST['favsub']);
    $percentage = intval($_POST['percentage'] ?? 0);
    $address = clean($conn, $_POST['address']);
    $city = clean($conn, $_POST['city']);
    $state = clean($conn, $_POST['state']);
    $pincode = clean($conn, $_POST['pincode']);
    $linkedin = clean($conn, $_POST['linkedin']);
    $github = clean($conn, $_POST['github']);
    $hobbies = clean($conn, $_POST['hobbies']);
    $clubs = $_POST['clubs'] ?? [];
    $skills = clean($conn, $_POST['skills']);
    $languages = clean($conn, $_POST['languages']);
    $dateTime = date('Y-m-d H:i:s');
    $clubs_csv = is_array($clubs) ? implode(",", $clubs) : "";

    // Check for duplicate email
    $email_check = $conn->query("SELECT email FROM students WHERE email='$email' LIMIT 1");
    if ($email_check->num_rows > 0) {
        echo "<script>alert('This email is already registered. Please use a different email.');window.history.back();</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // ==============================
    // FILE UPLOAD HANDLING
    // ==============================
    $photoPath = "";
    $documentPath = "";

    // Photo upload
    if (!empty($_FILES["photo"]["name"])) {
        $photoName = time() . "_" . basename($_FILES["photo"]["name"]);
        $targetPhoto = $uploadDir . $photoName;

        $imageFileType = strtolower(pathinfo($targetPhoto, PATHINFO_EXTENSION));
        $allowedImageTypes = ["jpg", "jpeg", "png", "gif", "webp"];
        if (in_array($imageFileType, $allowedImageTypes)) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPhoto)) {
                $photoPath = $targetPhoto;
            }
        }
    }

    // Document upload
    if (!empty($_FILES["document"]["name"])) {
        $docName = time() . "_" . basename($_FILES["document"]["name"]);
        $targetDoc = $uploadDir . $docName;

        $allowedDocTypes = ["pdf", "doc", "docx"];
        $docFileType = strtolower(pathinfo($targetDoc, PATHINFO_EXTENSION));
        if (in_array($docFileType, $allowedDocTypes)) {
            if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetDoc)) {
                $documentPath = $targetDoc;
            }
        }
    }

    // ==============================
    // INSERT INTO DATABASE
    // ==============================
    $stmt = $conn->prepare("INSERT INTO students 
        (fname, mname, lname, dob, gender, email, password, phone, color, photo, document, rollno, department, year, sem, cgpa, favsub, percentage, address, city, state, pincode, linkedin, github, hobbies, clubs, skills, languages, dateTime)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssssssssssssiidissssssssssss",
        $fname, $mname, $lname, $dob, $gender, $email, $hashed_password, $phone, $color, 
        $photoPath, $documentPath, $rollno, $department, $year, $sem, $cgpa, $favsub, $percentage,
        $address, $city, $state, $pincode, $linkedin, $github, $hobbies, $clubs_csv, $skills, $languages, $dateTime
    );

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!');window.location.href='student.php';</script>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
