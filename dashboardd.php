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
                <a href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="#"><i class="bi bi-door-open"></i> Rooms</a>
                <a href="#"><i class="bi bi-calendar-check"></i> Reservations</a>
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

            <div class="container mt-5 p-5 bg-light">
                <form action="" method="post">
                    <div class="row g-5">
                        <div class="col-auto">
                            <input type="search" name="search_input" placeholder="Search Reservations" class="form-control">
                        </div>
                        <div class="col-auto">
                            <input type="submit" name="search_btn" value="Search" class="btn-primary btn">
          </div>
    </div>
</form>

<?php

require_once "dbaseconnection.php" ;


if (isset($_POST['search_btn'])) {
    $search_input = $_POST['search_input'];
    $sql = "SELECT * FROM tbl_reservation WHERE 
            reservation_id LIKE '%".$search_input."%' OR
                check_in_date LIKE '%".$search_input."%' OR
                check_out_date LIKE '%".$search_input."%' OR
                reservation_status LIKE '%".$search_input."%'
                ";
    } else {
        $sql = "SELECT * FROM tbl_reservation";
    }

//convert string query to sql syntax and return a 2d array of records
$result = $conn->query($sql);

//check if the table is empty or not
//num_rows - count the number of records inside the table

if ($result->num_rows>0){
    ?>
   <table class="table table-success">
            <tr>
                <th>Reservation ID</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Reservation Status</th>
            </tr>

        <?php
    //display records from table
            foreach($result as  $field ){
                echo "<tr>";
                echo "<td>". $field['reservation_id'] ."</td>";
                echo "<td>". $field['check_in_date'] ."</td>";
                echo "<td>". $field['check_out_date'] ."</td>";
                echo "<td>". $field['reservation_status'] ."</td>";
                echo "</tr>";
            }
        ?>
    </table>
   
    <?php
   
    } else {
        echo "No reservations found";
    }
   
?>


</div>
</body>
</html>
