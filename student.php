<?php
include 'connect.php'; // Database connection
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registered Students</title>
  <style>
    :root {
      --brand:#13547a;
      --brand-dark:#0d3a55;
      --card-bg:#ffffff;
      --muted:#f5f8fb;
    }
    body {
      font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin:0;
      background:linear-gradient(135deg,#d9eaf7,#f8faff);
      color:#333;
      min-height:100vh;
      overflow-x:hidden;
    }

    /* ===== Header ===== */
    header {
      width:100%;
      position:fixed;
      top:0; left:0;
      padding:15px 40px;
      background:var(--card-bg);
      border-bottom:2px solid var(--brand);
      display:flex;
      justify-content:space-between;
      align-items:center;
      z-index:100;
      box-shadow:0px 2px 6px rgba(0,0,0,0.08);
    }
    header h2 {
      margin:0;
      font-size:1.6rem;
      color:var(--brand);
      font-weight:800;
      letter-spacing:1px;
    }
    nav a {
      text-decoration:none;
      background:var(--brand);
      color:#fff;
      padding:7px 14px;
      margin-left:6px;
      border-radius:20px;
      font-weight:500;
    }
    nav a:hover { background:var(--brand-dark); }

    /* ===== Main Content ===== */
    main {
      margin-top:130px; /* ⬅ increased to prevent overlap */
      padding:36px;
      background:var(--card-bg);
      width:90%;
      max-width:1200px;
      margin-left:auto;
      margin-right:auto;
      border-radius:12px;
      box-shadow:0 6px 22px rgba(19,84,122,0.08);
    }

    h2 {
      text-align:center;
      color:var(--brand);
      font-size:1.7rem;
      margin-bottom:22px;
    }

    /* ===== Table ===== */
    .table-wrap {
      width:100%;
      overflow-x:auto; /* ✅ horizontal scroll for smaller screens */
      border-radius:10px;
      box-shadow:0 3px 10px rgba(0,0,0,0.06);
      border:1px solid #e9eef4;
      background:white;
    }
    table {
      width:100%;
      border-collapse:collapse;
      font-size:0.95rem;
      min-width:1100px; /* ✅ prevents columns squishing */
    }
    thead th {
      background:var(--brand);
      color:#fff;
      padding:12px 10px;
      text-transform:uppercase;
      font-size:0.85rem;
      letter-spacing:.6px;
      text-align:left;
      position:sticky;
      top:0; /* ✅ keeps header visible while scrolling */
      z-index:50;
    }
    th, td {
      border-bottom:1px solid #eef3f7;
      padding:12px 10px;
      vertical-align:middle;
    }
    tbody tr:hover { background:var(--muted); }
    td.actions {
      width:200px;
      text-align:center;
      white-space:nowrap;
    }

    /* ===== Buttons ===== */
    .actions .btn {
      display:inline-block;
      margin:0 4px;
      padding:7px 12px;
      font-size:0.86rem;
      border-radius:20px;
      border:none;
      cursor:pointer;
      transition:transform .15s ease, opacity .15s ease;
    }
    .actions .view-btn { background:#2e8b57; color:white; }
    .actions .delete-btn { background:#d9534f; color:white; }
    .actions .btn:hover { transform:translateY(-2px); opacity:.95; }

    .back-btn {
      display:block;
      margin:26px auto 0;
      background:var(--brand);
      color:white;
      border:none;
      padding:10px 26px;
      border-radius:25px;
      cursor:pointer;
      font-weight:600;
    }
    .back-btn:hover { background:var(--brand-dark); }

    img.photo-thumb {
      width:60px;
      height:60px;
      border-radius:50%;
      object-fit:cover;
      box-shadow:0 3px 8px rgba(0,0,0,0.15);
    }

    a.file-link {
      color:#13547a;
      font-weight:600;
      text-decoration:none;
    }
    a.file-link:hover {
      text-decoration:underline;
    }

    /* ===== Responsive ===== */
    @media(max-width:768px){
      header {
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
        padding:12px 20px;
      }
      main { padding:20px; margin-top:160px; }
    }
  </style>
</head>
<body>
  <header>
    <h2>Engineering Student Registration</h2>
    <nav>
      <a href="index.html">Register</a>
      <a href="student.php" class="active">Student List</a>
    </nav>
  </header>

  <main>
    <h2>📋 Registered Students</h2>
    <div class="table-wrap">
      <table id="studentTable">
        <thead>
          <tr>
            <th>Roll No</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Year</th>
            <th>City</th>
            <th>Document</th>
            <th>Registered On</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php
          $query = "SELECT * FROM students ORDER BY id DESC";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>
                          <td>{$row['rollno']}</td>
                          <td>";
                          if (!empty($row['photo']) && file_exists($row['photo'])) {
                              echo "<img src='{$row['photo']}' alt='Photo' class='photo-thumb'>";
                          } else {
                              echo "No Photo";
                          }
                  echo    "</td>
                          <td>{$row['fname']} {$row['lname']}</td>
                          <td>{$row['gender']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['phone']}</td>
                          <td>{$row['department']}</td>
                          <td>{$row['year']}</td>
                          <td>{$row['city']}</td>
                          <td>";
                          if (!empty($row['document']) && file_exists($row['document'])) {
                              echo "<a class='file-link' href='{$row['document']}' target='_blank'>View File</a>";
                          } else {
                              echo "No File";
                          }
                  echo    "</td>
                          <td>{$row['created_at']}</td>
                          <td class='actions'>
                              <a class='btn view-btn' href='view.php?id={$row['id']}'>View</a>
                              <a class='btn delete-btn' href='delete.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='12' style='text-align:center;color:#888;'>No students registered yet.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <button class="back-btn" onclick="goBack()">⬅️ Back to Registration</button>
  </main>

  <script>
    const tableBody = document.getElementById("tableBody");
    const localStudents = JSON.parse(localStorage.getItem("students")) || [];

    // Append localStorage students below DB data
    if (localStudents.length > 0) {
      localStudents.forEach((s, i) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${s.rollno || "-"}</td>
          <td>No Photo</td>
          <td>${s.fname || ""} ${s.lname || ""}</td>
          <td>${s.gender || "-"}</td>
          <td>${s.email || "-"}</td>
          <td>${s.phone || "-"}</td>
          <td>${s.department || "-"}</td>
          <td>${s.year || "-"}</td>
          <td>${s.city || "-"}</td>
          <td>No File</td>
          <td>${s.dateTime || "-"}</td>
          <td class="actions">
            <button class="btn view-btn" onclick="viewLocal(${i})">View</button>
            <button class="btn delete-btn" onclick="deleteLocal(${i})">Delete</button>
          </td>`;
        tableBody.appendChild(row);
      });
    }

    function viewLocal(index) {
      const s = localStudents[index];
      alert(`Name: ${s.fname} ${s.lname}\nEmail: ${s.email}\nDepartment: ${s.department}\nYear: ${s.year}`);
    }

    function deleteLocal(index) {
      if (confirm("Delete this local record?")) {
        localStudents.splice(index, 1);
        localStorage.setItem("students", JSON.stringify(localStudents));
        location.reload();
      }
    }

    function goBack() { window.location.href = "index.html"; }
  </script>
</body>
</html>
