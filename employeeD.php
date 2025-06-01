<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Bloom & Belle Hotel - Reservations</title>
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
      min-height: 100vh;
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

  <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark px-5 py-3" style="background-color: var(--primary-color);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold nav-brand" href="index.php">
            <i class="bi bi-flower1 me-2"></i>The Bloom & Belle Hotel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-4">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'accom.php' ? 'active' : ''; ?>" href="accom.php">Accommodations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact Us</a>
                </li>
                <?php if(isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center">
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                    <a href="register.php" class="btn btn-light">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
  <div class="row">
<!-- Sidebar -->
<div class="col-md-2 sidebar">
  <div class="d-flex flex-column">
    <h5 class="mb-4">Menu</h5>
    <a href="finalindex.php" class="mb-3"><i class="bi bi-house me-2"></i>Home</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
  </div>
</div>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto p-0">
      <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h3>Reservations</h3>
        <span><i class="bi bi-person-circle"></i> Employee Panel</span>
      </div>

      <div class="container mt-4 bg-white p-4 rounded shadow">
        <!-- Search Form -->
        <form method="post" class="mb-4">
          <div class="row g-2">
            <div class="col-md-6">
              <input type="search" name="search_input" placeholder="Search Reservations" class="form-control">
            </div>
            <div class="col-md-auto">
            <input type="submit" name="search_btn" value="Search" style="background-color: #202e53; border: none; color: white;" class="btn">
            </div>
          </div>
        </form>

        <!-- PHP: Reservation Table -->
        <?php
        require_once "dbaseconnection.php";

        if (isset($_POST['search_btn'])) {
            $search_input = $_POST['search_input'];
            $sql = "SELECT * FROM tbl_reservation WHERE 
                      reservation_id LIKE '%$search_input%' OR
                      check_in_date LIKE '%$search_input%' OR
                      check_out_date LIKE '%$search_input%' OR
                      reservation_status LIKE '%$search_input%'";
        } else {
            $sql = "SELECT * FROM tbl_reservation";
        }

        $query = "SELECT * FROM tbl_customerdetails";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-success'>
                    <tr>
                      <th>Customer ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                    </tr>
                  </thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['account_id']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['lname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['pnumber']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No customer records found.</div>";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped table-hover'>";
            echo "<thead class='table-success'><tr>
                    <th>Reservation ID</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Status</th>
                  </tr></thead><tbody>";

            foreach ($result as $row) {
                echo "<tr>
                        <td>{$row['reservation_id']}</td>
                        <td>{$row['check_in_date']}</td>
                        <td>{$row['check_out_date']}</td>
                        <td>{$row['reservation_status']}</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No reservations found.</div>";
        }


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

         $query = "SELECT * FROM tbl_room";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-success'>
                    <tr>
                      <th>Room ID</th>
                      <th>Room Type</th>
                      <th>Price</th>
                      <th>Status</th>
                    </tr>
                  </thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['room_id']}</td>
                        <td>{$row['room_type']}</td>
                        <td>₱{$row['price_per_use']}</td>
                        <td>{$row['availability_status']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No rooms found.</div>";
        }
        ?>
      </div>
    </main>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
