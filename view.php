<?php
include 'connect.php'; // or connect.php if that’s your filename

if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("<h2 style='text-align:center;color:#d9534f;'>Invalid Request</h2>");
  exit;
}

$id = intval($_GET['id']);
$id = mysqli_real_escape_string($conn, $id);

$query = "SELECT * FROM students WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
  die("<h2 style='text-align:center;color:#d9534f;'>No student found!</h2>");
  exit;
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Details - <?php echo htmlspecialchars($row['fname']); ?></title>
<style>
  :root {
    --brand:#13547a;
    --brand-dark:#0d3a55;
    --muted:#f5f8fb;
  }
  body {
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background:linear-gradient(135deg,#d9eaf7,#f8faff);
    margin:0;
    padding:0;
    color:#333;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
  }
  .card {
    background:white;
    border-radius:14px;
    padding:28px 34px;
    width:90%;
    max-width:850px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    animation:fadeIn .4s ease;
    overflow-y:auto;
  }
  @keyframes fadeIn {
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
  }
  h2 {
    text-align:center;
    color:var(--brand);
    margin-bottom:18px;
    font-size:1.8rem;
  }
  .info {
    display:grid;
    grid-template-columns:180px 1fr;
    gap:12px;
    margin-top:10px;
  }
  .info strong {
    color:#0d3a55;
    font-weight:600;
  }
  .profile-img {
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    box-shadow:0 6px 16px rgba(0,0,0,0.12);
    display:block;
    margin:0 auto 14px;
  }
  .btn {
    display:inline-block;
    background:var(--brand);
    color:white;
    padding:8px 16px;
    border-radius:22px;
    border:none;
    cursor:pointer;
    font-weight:600;
    font-size:0.95rem;
    text-decoration:none;
    transition:background .2s ease;
  }
  .btn:hover { background:var(--brand-dark); }
  .edit-btn { background:#f0ad4e; }
  .edit-btn:hover { background:#d89024; }
  .section-title {
    margin-top:22px;
    font-size:1.15rem;
    color:var(--brand);
    border-bottom:2px solid #e0edf5;
    padding-bottom:6px;
    display:flex;
    align-items:center;
    gap:6px;
  }
  .section-title span { font-size:1.2rem; }
  a { color:#13547a; text-decoration:none; }
  a:hover { text-decoration:underline; }
  @media(max-width:600px){
    .info { grid-template-columns:1fr; }
    .info strong { display:block; margin-bottom:4px; }
  }
</style>
</head>
<body>
  <div class="card">
    <!-- ✅ Display Student Photo -->
    <img 
      src="<?php 
        if (!empty($row['photo'])) {
          echo 'display_image.php?id=' . urlencode($row['id']);
        } else {
          echo 'https://via.placeholder.com/140';
        }
      ?>" 
      alt="Student Photo" 
      class="profile-img">

    <h2><?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></h2>

    <div class="section-title"><span>👤</span> Personal Details</div>
    <div class="info">
      <strong>Roll No:</strong> <span><?php echo htmlspecialchars($row['rollno']); ?></span>
      <strong>Gender:</strong> <span><?php echo htmlspecialchars($row['gender']); ?></span>
      <strong>Email:</strong> <span><?php echo htmlspecialchars($row['email']); ?></span>
      <strong>Phone:</strong> <span><?php echo htmlspecialchars($row['phone']); ?></span>
      <strong>Date of Birth:</strong> <span><?php echo htmlspecialchars($row['dob']); ?></span>
      <strong>Password:</strong> <span><?php echo htmlspecialchars($row['password']); ?></span>
      <strong>Favorite Color:</strong>
      <span>
        <span style="background:<?php echo htmlspecialchars($row['color']); ?>;padding:2px 12px;border-radius:4px;">
          <?php echo htmlspecialchars($row['color']); ?>
        </span>
      </span>
    </div>

    <div class="section-title"><span>🏫</span> Academic Details</div>
    <div class="info">
      <strong>Department:</strong> <span><?php echo htmlspecialchars($row['department']); ?></span>
      <strong>Year:</strong> <span><?php echo htmlspecialchars($row['year']); ?></span>
      <strong>Semester:</strong> <span><?php echo htmlspecialchars($row['sem']); ?></span>
      <strong>CGPA:</strong> <span><?php echo htmlspecialchars($row['cgpa']); ?></span>
      <strong>Favorite Subject:</strong> <span><?php echo htmlspecialchars($row['favsub']); ?></span>
      <strong>Percentage:</strong> <span><?php echo htmlspecialchars($row['percentage']); ?>%</span>
    </div>

    <div class="section-title"><span>🏠</span> Address & Socials</div>
    <div class="info">
      <strong>Address:</strong> <span><?php echo htmlspecialchars($row['address']); ?></span>
      <strong>City:</strong> <span><?php echo htmlspecialchars($row['city']); ?></span>
      <strong>State:</strong> <span><?php echo htmlspecialchars($row['state']); ?></span>
      <strong>Pincode:</strong> <span><?php echo htmlspecialchars($row['pincode']); ?></span>
      <strong>LinkedIn:</strong> 
      <span>
        <?php if(!empty($row['linkedin'])): ?>
          <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" target="_blank"><?php echo htmlspecialchars($row['linkedin']); ?></a>
        <?php else: ?>
          <span>Not provided</span>
        <?php endif; ?>
      </span>
      <strong>GitHub:</strong> 
      <span>
        <?php if(!empty($row['github'])): ?>
          <a href="<?php echo htmlspecialchars($row['github']); ?>" target="_blank"><?php echo htmlspecialchars($row['github']); ?></a>
        <?php else: ?>
          <span>Not provided</span>
        <?php endif; ?>
      </span>
      <strong>Hobbies:</strong> <span><?php echo htmlspecialchars($row['hobbies']); ?></span>
      <strong>Skills:</strong> <span><?php echo htmlspecialchars($row['skills']); ?></span>
      <strong>Languages Known:</strong> <span><?php echo htmlspecialchars($row['languages']); ?></span>
    </div>

    <div class="section-title"><span>📄</span> Uploaded Documents</div>
    <div class="info">
      <strong>Resume:</strong>
      <?php if (!empty($row['document'])): ?>
        <a href="display_pdf.php?id=<?php echo urlencode($row['id']); ?>" target="_blank" class="btn">View PDF</a>
      <?php else: ?>
        <span>No document uploaded</span>
      <?php endif; ?>
    </div>

    <div style="text-align:center;margin-top:24px;">
      <a href="student.php" class="btn">⬅️ Back</a>
      <a href="edit.php?id=<?php echo urlencode($row['id']); ?>" class="btn edit-btn">✏️ Edit</a>
    </div>
  </div>
</body>
</html>
