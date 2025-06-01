<?php
session_start();
require_once "dbaseconnection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Amenities - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4A929E;
      --secondary-color: #ce6b6b;
      --dark-color: #202E53;
      --light-color: #BED4C3;
    }
    body {
      background-color: var(--light-color);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: var(--primary-color);
      padding: 1rem;
      color: white;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 0.5rem 0;
    }
    .sidebar a:hover {
      background-color: var(--dark-color);
      padding-left: 10px;
      transition: 0.3s;
    }
    .dashboard-header {
      background-color: var(--dark-color);
      color: white;
      padding: 1rem;
    }
  </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark px-5 py-3" style="background-color: var(--primary-color);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">
      <i class="bi bi-flower1 me-2"></i>The Bloom & Belle Hotel
    </a>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-outline-light">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </a>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
     <!-- Sidebar -->
    <nav class="col-md-2 d-none d-md-block sidebar">
  <div class="sidebar-sticky">
    <h4 class="mb-4">Admin Panel</h4>
    <a href="room.php"><i class="bi bi-door-open"></i> Rooms</a>
    <a href="reservationdash.php"><i class="bi bi-calendar-check"></i> Reservations</a>
    <a href="amenity.php"><i class="bi bi-gem"></i> Amenities</a>
    <a href="users.php"><i class="bi bi-people-fill"></i> Users</a>
    <a href="logs.php"><i class="bi bi-journal-text"></i> Logs</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>


    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto px-md-4">
      <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h3>Amenities</h3>
        <span><i class="bi bi-person-circle"></i> Admin Panel</span>
      </div>

      <div class="container mt-4 bg-white p-4 rounded shadow">
        <?php
        $query = "SELECT * FROM tbl_amenity";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-success'>
                    <tr>
                      <th>Amenity ID</th>
                      <th>Name</th>
                      <th>Description</th>
                    </tr>
                  </thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['amenity_id']}</td>
                        <td>{$row['amenity_name']}</td>
                        <td>{$row['description']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No amenities found.</div>";
        }
        ?>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
