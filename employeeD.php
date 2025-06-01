<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Bloom & Belle Hotel - Admin Dashboard</title>
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

    .card-custom {
      background-color: white;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card-custom .card-body {
      color: var(--dark-color);
    }
  </style>
</head>
<body>

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




    <main class="col-md-10 ms-sm-auto px-md-4">
      <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h3>Welcome, Admin</h3>
        <span><i class="bi bi-person-circle"></i> Admin Panel</span>
      </div>

      <div class="row mt-4">
        <div class="col-md-4">
          <div class="card card-custom">
            <div class="card-body">
              <h5 class="card-title">Total Rooms</h5>
              <p class="card-text display-6">48</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-custom">
            <div class="card-body">
              <h5 class="card-title">Current Guests</h5>
              <p class="card-text display-6">26</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-custom">
            <div class="card-body">
              <h5 class="card-title">Upcoming Reservations</h5>
              <p class="card-text display-6">14</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card card-custom">
            <div class="card-body">
              <h5 class="card-title">Recent Activity</h5>
              <ul class="list-group">
                <li class="list-group-item">Guest "Juan Dela Cruz" checked in.</li>
                <li class="list-group-item">Room 203 was cleaned by housekeeping.</li>
                <li class="list-group-item">Employee "Maria Santos" logged in.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
