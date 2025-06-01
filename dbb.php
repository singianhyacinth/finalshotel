<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Bloom & Belle Hotel - Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <h4 class="mb-4">Bloom & Belle</h4>
                <a href="dashboardd.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="#"><i class="bi bi-door-open"></i> Rooms</a>
                <a href="reservations"><i class="bi bi-calendar-check"></i> Reservations</a>
                <a href="#"><i class="bi bi-people"></i> Guests</a>
                <a href="#"><i class="bi bi-person-badge"></i> Employees</a>
                <a href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="dashboard-header d-flex justify-content-between align-items-center">
                <h3>Reservations</h3>
                <span><i class="bi bi-person-circle"></i> Admin Panel</span>
            </div>

<?php

require_once "dbaseconnection.php" ;

// Reservation table
$sql = "SELECT * FROM tbl_reservation";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>
    <table class="table table-success">
        <tr>
            <th>Reservation ID</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Reservation Status</th>
        </tr>
    <?php
    // Display records from table
    foreach ($result as $field) {
        echo "<tr>";
        echo "<td>" . $field['reservation_id'] . "</td>";
        echo "<td>" . $field['check_in_date'] . "</td>";
        echo "<td>" . $field['check_out_date'] . "</td>";
        echo "<td>" . $field['reservation_status'] . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    <?php
} else {
    echo "<div class='alert alert-warning'>No reservations found.</div>";
}


// amenity tbl
$sql_amenity = "SELECT * FROM tbl_amenity";
$result_amenity = $conn->query($sql_amenity);

if ($result_amenity->num_rows > 0) {
    echo '<table class="table table-success">
            <tr>
                <th>Amenity ID</th>
                <th>Amenity Name</th>
                <th>Description</th>
                <th>Price per use</th>
            </tr>';
    foreach ($result_amenity as $field) {
        echo "<tr>";
        echo "<td>" . $field['amenity_id'] . "</td>";
        echo "<td>" . $field['amenity_name'] . "</td>";
        echo "<td>" . $field['description'] . "</td>";
        echo "<td>" . $field['price_per_use'] . "</td>";
        echo "</tr>";
    }
    echo '</table>';
} else {
    echo "<div class='alert alert-warning'>No amenities found.</div>";
}

// logs tbl
$sql_logs = "SELECT * FROM tbl_logs";
$result_logs = $conn->query($sql_logs);

if ($result_logs->num_rows > 0) {
    echo '<table class="table table-success">
            <tr>
                <th>Log ID</th>
                <th>Action</th>
                <th>Datetime</th>
            </tr>';
    foreach ($result_logs as $field) {
        echo "<tr>";
        echo "<td>" . $field['log_id'] . "</td>";
        echo "<td>" . $field['action'] . "</td>";
        echo "<td>" . $field['datetime'] . "</td>";
        echo "</tr>";
    }
    echo '</table>';
} else {
    echo "<div class='alert alert-warning'>No logs found.</div>";
}

?>

</div>
</body>
</html>
