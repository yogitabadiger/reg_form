<?php
include 'connect.php';

$id = $_GET['id'] ?? '';

if ($id) {
    $sql = "SELECT * FROM students WHERE id='$id'";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $student = $res->fetch_assoc();
    } else {
        echo "<script>alert('Student not found'); window.location='student.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Student Details</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #d9eaf7, #f8faff);
      color: #333;
      min-height: 100vh;
    }
    header {
      background: white;
      border-bottom: 2px solid #13547a;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      width: 100%;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
      z-index: 100;
    }
    header h2 {
      margin: 0;
      color: #13547a;
      font-weight: 800;
    }
    nav a {
      text-decoration: none;
      background: #13547a;
      color: #fff;
      padding: 8px 16px;
      border-radius: 20px;
      margin-left: 10px;
    }
    nav a:hover { background: #0d3a55; }
    .container {
      margin-top: 120px;
      background: white;
      border-radius: 12px;
      width: 85%;
      max-width: 900px;
      margin-inline: auto;
      padding: 35px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    h2 { text-align: center; color: #13547a; }
    label { display:block; margin-top:10px; font-weight:500; }
    input, select, textarea {
      width:100%;
      padding:8px;
      border:1px solid #ccc;
      border-radius:6px;
      font-size:1rem;
    }
    input[type="radio"], input[type="checkbox"] { width:auto; margin-right:5px; }
    .buttons { text-align:center; margin-top:25px; }
    .buttons button {
      background:#13547a;
      color:white;
      border:none;
      padding:10px 25px;
      margin:5px;
      border-radius:25px;
      cursor:pointer;
      font-size:1rem;
    }
    .buttons button:hover { background:#0d3a55; }
    .preview {
      margin-top: 10px;
      text-align: center;
    }
    .preview img {
      max-width: 120px;
      border-radius: 10px;
      margin-top: 10px;
      border: 2px solid #ccc;
    }
  </style>
</head>
<body>
  <header>
    <h2>Edit Student Details</h2>
    <nav>
      <a href="index.html">Register</a>
      <a href="student.php">Student List</a>
    </nav>
  </header>

  <div class="container">
    <h2>✏️ Edit Student</h2>
    <form id="editForm" enctype="multipart/form-data" method="POST" action="update.php">
      <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

      <h3>👤 Personal Details</h3>
      <label>First Name:</label><input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>" required>
      <label>Middle Name:</label><input type="text" name="mname" id="mname" value="<?php echo $student['mname']; ?>">
      <label>Last Name:</label><input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>" required>
      <label>Date of Birth:</label><input type="date" name="dob" id="dob" value="<?php echo $student['dob']; ?>" required>
      <label>Gender:</label>
      <input type="radio" name="gender" value="Male" <?php if($student['gender']=='Male') echo 'checked'; ?>> Male
      <input type="radio" name="gender" value="Female" <?php if($student['gender']=='Female') echo 'checked'; ?>> Female
      <input type="radio" name="gender" value="Other" <?php if($student['gender']=='Other') echo 'checked'; ?>> Other
      <label>Email:</label><input type="email" name="email" id="email" value="<?php echo $student['email']; ?>" required>
      <label>Password:</label><input type="password" name="password" id="password" value="<?php echo $student['password']; ?>" required>
      <label>Phone:</label><input type="tel" name="phone" id="phone" value="<?php echo $student['phone']; ?>" pattern="[0-9]{10}" required>
      <label>Favorite Color:</label><input type="color" name="color" id="color" value="<?php echo $student['color']; ?>">
      <label>Profile Photo:</label><input type="file" name="photo" id="photo" accept="image/*">
      <div class="preview">
        <?php if(!empty($student['photo'])): ?>
        <?php endif; ?>
      </div>
      <label>Upload Resume:</label><input type="file" name="document" id="document" accept="application/pdf">
      <div class="preview">
        <?php if(!empty($student['document'])): ?>
        <?php endif; ?>
      </div>

      <h3>🏫 Academic Details</h3>
      <label>USN Number:</label><input type="text" name="rollno" id="rollno" value="<?php echo $student['rollno']; ?>" required>
      <label>Department:</label>
      <select name="department" id="department" required>
        <option <?php if($student['department']=='CSE') echo 'selected'; ?>>CSE</option>
        <option <?php if($student['department']=='ECE') echo 'selected'; ?>>ECE</option>
        <option <?php if($student['department']=='AI&ML') echo 'selected'; ?>>AI&ML</option>
        <option <?php if($student['department']=='IS') echo 'selected'; ?>>IS</option>
        <option <?php if($student['department']=='MECH') echo 'selected'; ?>>MECH</option>
        <option <?php if($student['department']=='CIVIL') echo 'selected'; ?>>CIVIL</option>
        <option <?php if($student['department']=='EEE') echo 'selected'; ?>>EEE</option>
      </select>
      <label>Year:</label><input type="number" name="year" id="year" value="<?php echo $student['year']; ?>" required>
      <label>Semester:</label><input type="number" name="sem" id="sem" value="<?php echo $student['sem']; ?>" required>
      <label>CGPA:</label><input type="number" name="cgpa" id="cgpa" value="<?php echo $student['cgpa']; ?>" step="0.01">
      <label>Favorite Subject:</label>
        <input type="text" list="subjects" id="favsub" name="favsub">
        <datalist id="subjects">
          <option>JAVA</option><option>HTML</option><option>C</option>
          <option>C++</option><option>DS</option><option>PYTHON</option>
          <option>DBMS</option><option>OS</option><option>Networks</option>
          <option>AI</option><option>ML</option>
        </datalist>
      <label>Last Semester Percentage:</label>
      <input type="range" name="percentage" id="percentage" min="0" max="100" value="<?php echo $student['percentage']; ?>" oninput="document.getElementById('percentageOutput').value=this.value">
      <output id="percentageOutput"><?php echo $student['percentage']; ?></output>%

      <h3>⚙️ Additional Details</h3>
      <label>Address:</label><textarea name="address" id="address" rows="3"><?php echo $student['address']; ?></textarea>
      <label>City:</label><input type="text" name="city" id="city" value="<?php echo $student['city']; ?>">
      <label>State:</label>
      <select name="state" id="state" required>
        <option value="">--Select--</option>
        <option <?php if($student['state']=='Karnataka') echo 'selected'; ?>>Karnataka</option>
        <option <?php if($student['state']=='Tamil Nadu') echo 'selected'; ?>>Tamil Nadu</option>
        <option <?php if($student['state']=='Maharashtra') echo 'selected'; ?>>Maharashtra</option>
        <option <?php if($student['state']=='Kerala') echo 'selected'; ?>>Kerala</option>
      </select>
      <label>Pincode:</label><input type="number" name="pincode" id="pincode" value="<?php echo $student['pincode']; ?>">
      <label>LinkedIn:</label><input type="url" name="linkedin" id="linkedin" value="<?php echo $student['linkedin']; ?>">
      <label>GitHub:</label><input type="url" name="github" id="github" value="<?php echo $student['github']; ?>">
      <label>Hobbies:</label><input type="text" id="hobbies" name="hobbies" placeholder="Reading, Coding, etc.">
        <label>Clubs Interested:</label><br>
        <input type="checkbox" name="clubs" value="Coding"> Coding
        <input type="checkbox" name="clubs" value="Robotics"> Robotics
        <input type="checkbox" name="clubs" value="Music"> Music
        <input type="checkbox" name="clubs" value="Sports"> Sports <br><br>
      <label>Skills:</label><input type="search" id="skills" name="skills" placeholder="Search skills">
      <label>Languages Known:</label><input type="text" id="languages" name="languages" list="langList">
        <datalist id="langList"><option>English</option><option>Hindi</option><option>Kannada</option></datalist>
      <div class="buttons">
        <button type="submit">💾 Save Changes</button>
        <button type="button" onclick="window.location.href='student.php'">❌ Cancel</button>
      </div>
    </form>
  </div>
</body>
</html>
