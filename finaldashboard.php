<?php
session_start();
require_once 'dbaseconnection.php'; // Database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_role = strtolower($_SESSION['role']); // 'admin', 'employee', or 'customer'

// Fetch user details
$user_query = "SELECT * FROM tbl_customerdetails WHERE account_id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Get counts for dashboard cards
$room_count = $conn->query("SELECT COUNT(*) FROM tbl_room")->fetch_row()[0];
$available_count = $conn->query("SELECT COUNT(*) FROM tbl_room WHERE availability_status = 'available'")->fetch_row()[0];
$reservation_count = $conn->query("SELECT COUNT(*) FROM tbl_reservation")->fetch_row()[0];
$pending_reservations = $conn->query("SELECT COUNT(*) FROM tbl_reservation WHERE reservation_status = 'pending'")->fetch_row()[0];
$active_reservations = $conn->query("SELECT COUNT(*) FROM tbl_reservation WHERE reservation_status = 'confirmed' AND check_out_date > NOW()")->fetch_row()[0];
$user_reservations = $conn->query("SELECT COUNT(*) FROM tbl_reservation WHERE user_id = $user_id")->fetch_row()[0];
$amenity_count = $conn->query("SELECT COUNT(*) FROM tbl_ammenity")->fetch_row()[0];
$feedback_count = $conn->query("SELECT COUNT(*) FROM tbl_feedback")->fetch_row()[0];

// Set page title based on role
$page_title = ucfirst($user_role) . " Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($page_title); ?> | The Bloom & Belle Hotel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4A929E;
      --secondary-color: #F9B1A9;
      --background-color: #f8f9fa;
      --card-color: #ffffff;
      --text-color: #333333;
    }
    body {
      background-color: var(--background-color);
      font-family: 'Segoe UI', sans-serif;
      color: var(--text-color);
    }
    .sidebar {
      background-color: var(--primary-color);
      min-height: 100vh;
      color: white;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    .sidebar .nav-link {
      color: white;
      border-radius: 5px;
      margin: 2px 0;
      transition: all 0.3s;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: rgba(255,255,255,0.2);
      transform: translateX(5px);
    }
    .sidebar .nav-link i {
      width: 24px;
      text-align: center;
    }
    .profile-card, .reservation-card {
      background-color: var(--card-color);
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .dashboard-card {
      transition: transform 0.3s, box-shadow 0.3s;
      border: none;
      border-radius: 10px;
    }
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-icon {
      font-size: 2rem;
      margin-bottom: 15px;
    }
    .navbar {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .welcome-section {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      border-radius: 10px;
      padding: 2rem;
      margin-bottom: 2rem;
    }
    .recent-activity {
      max-height: 400px;
      overflow-y: auto;
    }
    .activity-item {
      border-left: 3px solid var(--primary-color);
      padding-left: 15px;
      margin-bottom: 15px;
    }
    .status-badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    .status-pending {
      background-color: #FFF3CD;
      color: #856404;
    }
    .status-confirmed {
      background-color: #D4EDDA;
      color: #155724;
    }
    .status-cancelled {
      background-color: #F8D7DA;
      color: #721C24;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3" style="background-color: var(--primary-color);">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold nav-brand" href="dashboard.php">
            <i class="bi bi-flower1 me-2"></i>The Bloom & Belle Hotel
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-4">
              <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="rooms.php">Rooms</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
            <div class="d-flex align-items-center">
              <span class="text-white me-3">Welcome, <?php echo htmlspecialchars($user['fname']); ?></span>
              <a href="logout.php" class="btn btn-outline-light">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </a>
            </div>
          </div>
        </div>
      </nav>

      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
        <div class="position-sticky pt-3">
          <div class="text-center mb-4">
            <img src="<?php echo htmlspecialchars($user['image'] ?? 'default-profile.png'); ?>" alt="Profile Picture" class="rounded-circle" style="height: 100px; width: 100px; object-fit: cover; border: 3px solid white;">
            <h5 class="mt-2"><?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></h5>
            <small class="badge bg-light text-dark"><?php echo ucfirst($user_role); ?></small>
          </div>
          
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="dashboard.php">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
              </a>
            </li>
            
            <?php if ($user_role == 'admin' || $user_role == 'employee'): ?>
              <li class="nav-item">
                <a class="nav-link" href="rooms.php">
                  <i class="bi bi-door-closed me-2"></i>Room Management
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="reservations.php">
                  <i class="bi bi-calendar-check me-2"></i>Reservations
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="amenities.php">
                  <i class="bi bi-tv me-2"></i>Amenities
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="feedback.php">
                  <i class="bi bi-chat-square-text me-2"></i>Feedback
                </a>
              </li>
            <?php endif; ?>
            
            <?php if ($user_role == 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link" href="users.php">
                  <i class="bi bi-people me-2"></i>User Management
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logs.php">
                  <i class="bi bi-clock-history me-2"></i>System Logs
                </a>
              </li>
            <?php endif; ?>
            
            <?php if ($user_role == 'customer'): ?>
              <li class="nav-item">
                <a class="nav-link" href="reserve.php">
                  <i class="bi bi-plus-circle me-2"></i>Make Reservation
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my_reservations.php">
                  <i class="bi bi-list-check me-2"></i>My Reservations
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="profile.php">
                  <i class="bi bi-person me-2"></i>My Profile
                </a>
              </li>
            <?php endif; ?>
            
            <li class="nav-item mt-3">
              <a class="nav-link text-danger" href="logout.php">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><?php echo $page_title; ?></h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Print
              </button>
            </div>
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                <i class="bi bi-calendar"></i> <?php echo date('F Y'); ?>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">This Week</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section mb-4">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h2>Welcome back, <?php echo htmlspecialchars($user['fname']); ?>!</h2>
              <p class="mb-0">Here's what's happening with your hotel <?php echo $user_role == 'customer' ? 'reservations' : 'operations'; ?> today.</p>
            </div>
            <div class="col-md-4 text-md-end">
              <i class="bi bi-flower2" style="font-size: 3rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>

        <!-- Dashboard Content Based on User Role -->
        <div class="dashboard-content">
          <?php if ($user_role == 'admin'): ?>
            <!-- Admin Dashboard Content -->
            <div class="row mb-4">
              <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-primary text-white">
                  <div class="card-body text-center">
                    <i class="bi bi-door-open card-icon"></i>
                    <h5 class="card-title">Total Rooms</h5>
                    <p class="card-text display-4 mb-0"><?php echo $room_count; ?></p>
                    <a href="rooms.php" class="text-white small">View all rooms</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-success text-white">
                  <div class="card-body text-center">
                    <i class="bi bi-check-circle card-icon"></i>
                    <h5 class="card-title">Available Rooms</h5>
                    <p class="card-text display-4 mb-0"><?php echo $available_count; ?></p>
                    <a href="rooms.php?status=available" class="text-white small">View available</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-warning text-dark">
                  <div class="card-body text-center">
                    <i class="bi bi-hourglass-split card-icon"></i>
                    <h5 class="card-title">Pending Reservations</h5>
                    <p class="card-text display-4 mb-0"><?php echo $pending_reservations; ?></p>
                    <a href="reservations.php?status=pending" class="text-dark small">Review now</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3 mb-3">
                <div class="card dashboard-card bg-info text-white">
                  <div class="card-body text-center">
                    <i class="bi bi-people card-icon"></i>
                    <h5 class="card-title">Total Users</h5>
                    <?php
                    $user_count = $conn->query("SELECT COUNT(*) FROM tbl_customerdetails")->fetch_row()[0];
                    ?>
                    <p class="card-text display-4 mb-0"><?php echo $user_count; ?></p>
                    <a href="users.php" class="text-white small">Manage users</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Recent Activities Section -->
            <div class="row">
              <div class="col-md-8 mb-4">
                <div class="card">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Reservations</h5>
                  </div>
                  <div class="card-body recent-activity">
                    <?php
                    $recent_reservations = $conn->query("
                      SELECT r.*, c.fname, c.lname, rm.room_number 
                      FROM tbl_reservation r
                      JOIN tbl_customerdetails c ON r.user_id = c.account_id
                      JOIN tbl_room rm ON r.room_id = rm.room_id
                      ORDER BY r.reservation_id DESC LIMIT 5
                    ");
                    
                    if ($recent_reservations->num_rows > 0) {
                      while($reservation = $recent_reservations->fetch_assoc()) {
                        $status_class = '';
                        if ($reservation['reservation_status'] == 'pending') $status_class = 'status-pending';
                        elseif ($reservation['reservation_status'] == 'confirmed') $status_class = 'status-confirmed';
                        else $status_class = 'status-cancelled';
                        
                        echo '<div class="activity-item mb-3">
                          <div class="d-flex justify-content-between">
                            <div>
                              <strong>'.$reservation['fname'].' '.$reservation['lname'].'</strong>
                              <span class="text-muted small"> - Room '.$reservation['room_number'].'</span>
                            </div>
                            <span class="status-badge '.$status_class.'">'.ucfirst($reservation['reservation_status']).'</span>
                          </div>
                          <div class="d-flex justify-content-between text-muted small">
                            <span>'.date('M d, Y', strtotime($reservation['check_in_date'])).' to '.date('M d, Y', strtotime($reservation['check_out_date'])).'</span>
                            <span>₱'.number_format($reservation['total_price'], 2).'</span>
                          </div>
                        </div>';
                      }
                    } else {
                      echo '<p class="text-muted">No recent reservations found.</p>';
                    }
                    ?>
                  </div>
                  <div class="card-footer bg-white text-end">
                    <a href="reservations.php" class="btn btn-sm btn-primary">View All Reservations</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-4">
                <div class="card">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                  </div>
                  <div class="card-body">
                    <a href="add_room.php" class="btn btn-outline-primary w-100 mb-2">
                      <i class="bi bi-plus-circle"></i> Add New Room
                    </a>
                    <a href="reports.php" class="btn btn-outline-success w-100 mb-2">
                      <i class="bi bi-file-earmark-bar-graph"></i> Generate Reports
                    </a>
                    <a href="settings.php" class="btn btn-outline-info w-100 mb-2">
                      <i class="bi bi-gear"></i> System Settings
                    </a>
                    <a href="backup.php" class="btn btn-outline-warning w-100">
                      <i class="bi bi-database"></i> Backup Database
                    </a>
                  </div>
                </div>
              </div>
            </div>

          <?php elseif ($user_role == 'employee'): ?>
            <!-- Employee Dashboard Content -->
            <div class="row mb-4">
              <div class="col-md-4 mb-3">
                <div class="card dashboard-card bg-primary text-white">
                  <div class="card-body text-center">
                    <i class="bi bi-door-open card-icon"></i>
                    <h5 class="card-title">Available Rooms</h5>
                    <p class="card-text display-4 mb-0"><?php echo $available_count; ?></p>
                    <a href="rooms.php?status=available" class="text-white small">View available</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <div class="card dashboard-card bg-warning text-dark">
                  <div class="card-body text-center">
                    <i class="bi bi-hourglass-split card-icon"></i>
                    <h5 class="card-title">Pending Approvals</h5>
                    <p class="card-text display-4 mb-0"><?php echo $pending_reservations; ?></p>
                    <a href="reservations.php?status=pending" class="text-dark small">Review now</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <div class="card dashboard-card bg-success text-white">
                  <div class="card-body text-center">
                    <i class="bi bi-calendar-check card-icon"></i>
                    <h5 class="card-title">Active Reservations</h5>
                    <p class="card-text display-4 mb-0"><?php echo $active_reservations; ?></p>
                    <a href="reservations.php?status=confirmed" class="text-white small">View active</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Pending Reservations Table -->
            <div class="card mb-4">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pending Reservations</h5>
                <a href="reservations.php" class="btn btn-sm btn-primary">View All</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Reservation ID</th>
                        <th>Guest Name</th>
                        <th>Room</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $pending_query = $conn->query("
                        SELECT r.*, c.fname, c.lname, rm.room_number, rm.room_type 
                        FROM tbl_reservation r
                        JOIN tbl_customerdetails c ON r.user_id = c.account_id
                        JOIN tbl_room rm ON r.room_id = rm.room_id
                        WHERE r.reservation_status = 'pending'
                        ORDER BY r.reservation_id DESC LIMIT 5
                      ");
                      
                      if ($pending_query->num_rows > 0) {
                        while($reservation = $pending_query->fetch_assoc()) {
                          echo '<tr>
                            <td>'.$reservation['reservation_id'].'</td>
                            <td>'.$reservation['fname'].' '.$reservation['lname'].'</td>
                            <td>'.$reservation['room_number'].' ('.ucfirst($reservation['room_type']).')</td>
                            <td>'.date('M d, Y', strtotime($reservation['check_in_date'])).'</td>
                            <td>'.date('M d, Y', strtotime($reservation['check_out_date'])).'</td>
                            <td>₱'.number_format($reservation['total_price'], 2).'</td>
                            <td>
                              <a href="approve_reservation.php?id='.$reservation['reservation_id'].'" class="btn btn-sm btn-success">Approve</a>
                              <a href="reject_reservation.php?id='.$reservation['reservation_id'].'" class="btn btn-sm btn-danger">Reject</a>
                            </td>
                          </tr>';
                        }
                      } else {
                        echo '<tr><td colspan="7" class="text-center">No pending reservations</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
            <!-- Quick Actions for Employee -->
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="card">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Today's Check-Ins</h5>
                  </div>
                  <div class="card-body">
                    <?php
                    $today_checkins = $conn->query("
                      SELECT r.*, c.fname, c.lname, rm.room_number 
                      FROM tbl_reservation r
                      JOIN tbl_customerdetails c ON r.user_id = c.account_id
                      JOIN tbl_room rm ON r.room_id = rm.room_id
                      WHERE DATE(r.check_in_date) = CURDATE() AND r.reservation_status = 'confirmed'
                      LIMIT 3
                    ");
                    
                    if ($today_checkins->num_rows > 0) {
                      while($checkin = $today_checkins->fetch_assoc()) {
                        echo '<div class="mb-3">
                          <div class="d-flex justify-content-between">
                            <strong>'.$checkin['fname'].' '.$checkin['lname'].'</strong>
                            <span class="badge bg-primary">Room '.$checkin['room_number'].'</span>
                          </div>
                          <div class="text-muted small">
                            '.date('h:i A', strtotime($checkin['check_in_date'])).'
                          </div>
                        </div>';
                      }
                    } else {
                      echo '<p class="text-muted">No check-ins scheduled for today.</p>';
                    }
                    ?>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6 mb-4">
                <div class="card">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                  </div>
                  <div class="card-body">
                    <a href="checkin.php" class="btn btn-outline-primary w-100 mb-2">
                      <i class="bi bi-box-arrow-in-right"></i> Process Check-In
                    </a>
                    <a href="checkout.php" class="btn btn-outline-success w-100 mb-2">
                      <i class="bi bi-box-arrow-right"></i> Process Check-Out
                    </a>
                    <a href="rooms.php" class="btn btn-outline-info w-100">
                      <i class="bi bi-search"></i> Room Availability
                    </a>
                  </div>
                </div>
              </div>
            </div>

          <?php else: ?>
            <!-- Customer Dashboard Content -->
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="profile-card">
                  <div class="d-flex align-items-center">
                    <img src="<?php echo htmlspecialchars($user['image'] ?? 'default-profile.png'); ?>" alt="Profile Picture" class="rounded-circle me-3" style="height: 80px; width: 80px; object-fit: cover; border: 2px solid #555;">
                    <div>
                      <h4 class="mb-1"><?php echo htmlspecialchars($user['fname'] . ' ' . $user['lname']); ?></h4>
                      <p class="mb-1 text-muted"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                      <p class="mb-0 text-muted"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($user['pnumber']); ?></p>
                    </div>
                  </div>
                  <hr>
                  <div class="text-center">
                    <a href="profile.php" class="btn btn-primary">Edit Profile</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-8 mb-4">
                <div class="card">
                  <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Reservations</h5>
                    <a href="reserve.php" class="btn btn-sm btn-primary">New Reservation</a>
                  </div>
                  <div class="card-body">
                    <?php
                    $user_reservations_query = $conn->query("
                      SELECT r.*, rm.room_number, rm.room_type 
                      FROM tbl_reservation r
                      JOIN tbl_room rm ON r.room_id = rm.room_id
                      WHERE r.user_id = $user_id
                      ORDER BY r.check_in_date DESC LIMIT 3
                    ");
                    
                    if ($user_reservations_query->num_rows > 0) {
                      echo '<div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>Room</th>
                              <th>Check-In</th>
                              <th>Check-Out</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>';
                      
                      while($reservation = $user_reservations_query->fetch_assoc()) {
                        $status_class = '';
                        if ($reservation['reservation_status'] == 'pending') $status_class = 'status-pending';
                        elseif ($reservation['reservation_status'] == 'confirmed') $status_class = 'status-confirmed';
                        else $status_class = 'status-cancelled';
                        
                        echo '<tr>
                          <td>'.$reservation['room_number'].' ('.ucfirst($reservation['room_type']).')</td>
                          <td>'.date('M d, Y', strtotime($reservation['check_in_date'])).'</td>
                          <td>'.date('M d, Y', strtotime($reservation['check_out_date'])).'</td>
                          <td><span class="status-badge '.$status_class.'">'.ucfirst($reservation['reservation_status']).'</span></td>
                          <td>
                            <a href="view_reservation.php?id='.$reservation['reservation_id'].'" class="btn btn-sm btn-outline-primary">View</a>';
                        
                        if ($reservation['reservation_status'] == 'pending') {
                          echo '<a href="cancel_reservation.php?id='.$reservation['reservation_id'].'" class="btn btn-sm btn-outline-danger ms-1">Cancel</a>';
                        }
                        
                        echo '</td>
                        </tr>';
                      }
                      
                      echo '</tbody>
                        </table>
                      </div>';
                    } else {
                      echo '<div class="text-center py-4">
                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">No Reservations Yet</h5>
                        <p class="text-muted">You haven\'t made any reservations yet.</p>
                        <a href="reserve.php" class="btn btn-primary">Book a Room Now</a>
                      </div>';
                    }
                    ?>
                  </div>
                  <div class="card-footer bg-white text-end">
                    <a href="my_reservations.php" class="btn btn-sm btn-outline-primary">View All Reservations</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Available Rooms Section -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Available Rooms</h5>
                  </div>
                  <div class="card-body">
                    <?php
                    $available_rooms = $conn->query("
                      SELECT * FROM tbl_room 
                      WHERE availability_status = 'available'
                      ORDER BY room_type LIMIT 3
                    ");
                    
                    if ($available_rooms->num_rows > 0) {
                      echo '<div class="row">';
                      
                      while($room = $available_rooms->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-3">
                          <div class="card h-100">
                            <img src="room_images/'.$room['room_id'].'.jpg" class="card-img-top" alt="Room Image" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                              <h5 class="card-title">'.ucfirst($room['room_type']).' Room</h5>
                              <p class="card-text text-muted small">'.$room['description'].'</p>
                              <ul class="list-unstyled small">
                                <li><i class="bi bi-people"></i> Capacity: '.$room['capacity'].'</li>
                                <li><i class="bi bi-cash"></i> ₱'.number_format($room['price_per_use'], 2).' per night</li>
                              </ul>
                            </div>
                            <div class="card-footer bg-white">
                              <a href="reserve.php?room_id='.$room['room_id'].'" class="btn btn-primary w-100">Book Now</a>
                            </div>
                          </div>
                        </div>';
                      }
                      
                      echo '</div>';
                    } else {
                      echo '<div class="text-center py-4">
                        <i class="bi bi-door-closed" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">No Available Rooms</h5>
                        <p class="text-muted">All our rooms are currently occupied. Please check back later.</p>
                      </div>';
                    }
                    ?>
                  </div>
                  <div class="card-footer bg-white text-end">
                    <a href="rooms.php" class="btn btn-sm btn-outline-primary">View All Rooms</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </main>
    </div>
  </div>
      <!-- footer -->
    <footer class="py-4" style="background-color: #4A929E;">
      <div class="container">
          <div class="row align-items-center">

              <!-- logo and hotel name -->
              <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                  <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                      <img src="images/bblogo.png" alt="Logo" class="me-3 rounded-1" style="height: 80px; border: 1px solid #202E53;">
                      <div class="footer-logo" style="font-size: 1.8rem; font-weight: 600;">The Bloom & Belle Hotel</div>
                  </div>
              </div>

              <!-- navigation Links -->
              <div class="col-md-4 mb-4 mb-md-0 d-flex justify-content-center">
                  <div class="footer-links text-start"> 
                      <a href="#" class="d-block mb-2">Home</a>
                      <a href="#" class="d-block mb-2">Profile</a>
                      <a href="#" class="d-block mb-2">Login</a>
                      <a href="#" class="d-block mb-2">Contact Us</a>
                      <a href="#" class="d-block mb-2">Accommodations</a>
                  </div>
              </div>
              
              <!-- contact info with socmed -->
              <div class="col-md-4">
                  <div class="footer-contact text-start">
                      <!-- socmed icons -->
                      <div class="social-media mb-3">
                          <a href="#" class="mx-2"><img src="images/fb.png" alt="Facebook" style="height: 30px;"></a>
                          <a href="#" class="mx-2"><img src="images/ig.png" alt="Instagram" style="height: 30px;"></a>
                          <a href="#" class="mx-2"><img src="images/tt.png" alt="Tiktok" style="height: 30px;"></a>
                      </div>
                      <p class="mb-1">1234 M.H. Del Pilar Street, Erruna, Manila,</p>
                      <p class="mb-1">1000 Metro Manila, Philippines</p>
                      <p class="mb-1"><b>info@thebloom&bellehotel.ph</b></p>
                      <p class="mb-1"><b>+63 (2) 8685-1234</b></p>
                  </div>
              </div>
          </div>
      </div>
    </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
