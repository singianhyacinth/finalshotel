<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body {
        background-color: #BED4C3;
        margin: 0;
        padding: 0;
      }
      .form-section {
        padding: 50px;
      }
      .form-control, .form-check-input {
        border-radius: 0;
        border: 1px solid #000;
      }
      .btn-custom {
        background-color: #102E53;
        color: white;
        border-radius: 0;
        font-weight: bold;
      }
      .gender-options {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 8px;
      }
      :root {
        --primary-color: #4a929e;
        --secondary-color: #ce6b6b;
        --dark-color: #202e53;
        --light-color: #bed4c3;
      }
      .form-container {
        background-color: white;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
      }
    </style>
  </head>
  <body>

   <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3" style="background-color: var(--primary-color);">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold nav-brand" href="#">
        <i class="bi bi-flower1 me-2"></i>The Bloom & Belle Hotel
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-4">
          <li class="nav-item">
            <a class="nav-link active" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Accommodations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
        </ul>
        <button class="btn btn-outline-light">
          <i class="bi bi-person-circle me-1"></i> Login
        </button>
      </div>
    </div>
  </nav>

    <div class="container-fluid">
      <div class="row">
        <!-- Image Section -->
        <div class="col-md-6 p-0 d-none d-md-block">
          <img src="images/main.jpg" alt="Hotel Room" class="w-100 h-100" style="object-fit: cover; min-height: 100vh;">
        </div>

        <!-- Form Section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 72px);">
          <div class="form-container w-100">
            <h3 class="fw-bold mb-4">Create your Account</h3>
            
            <form action="register.php" method="POST" onsubmit="return validateForm()">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">First Name</label>
                  <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Last Name</label>
                  <input type="text" class="form-control" name="last_name" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Gender</label>
                  <div class="gender-options">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" value="Male" id="male" required>
                      <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" value="Female" id="female">
                      <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" value="Others" id="others">
                      <label class="form-check-label" for="others">Others</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>

              <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required minlength="6">
                <small class="text-muted">Minimum 6 characters</small>
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" required>
                <label class="form-check-label" for="terms">I agree to the Terms and Conditions</label>
              </div>

              <div class="mb-3 text-center">
                <button type="submit" class="btn btn-custom w-100 py-2">Sign up</button>
              </div>

              <div class="text-center">
                Already have an account? <a href="login.html" class="text-dark fw-bold">Log in now.</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



     <script>
      function validateForm() {
        const password = document.querySelector('input[name="password"]');
        if (password.value.length < 6) {
          Swal.fire({
            icon: 'error',
            title: 'Password too short',
            text: 'Password must be at least 6 characters long',
            confirmButtonColor: '#102E53'
          });
          return false;
        }
        return true;
      }
      
      // Display any PHP errors
      <?php if(isset($error)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Registration Error',
          text: '<?php echo $error; ?>',
          confirmButtonColor: '#102E53'
        });
      <?php endif; ?>
    </script>

  </body>
</html>

<?php
// Enable error reporting (at the VERY TOP)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "dbaseconnection.php";
include "emailverify.php";

// Check if form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {

    // Retrieve form values
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $fullname = $fname . " " . $lname;
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $username = $_POST['username'];
    $pass = md5($_POST['password']); // Using MD5 as requested
    
    // Default values
    $imagepath = "images/default-profile.jpg";
    $otp = rand(100000, 999999);
    $status = "Pending";
    $addinfo = ""; // Additional info if needed
    $role = "Customer"; // Default role

    // SQL insert statement (following your required pattern)
    $insertsql = "INSERT INTO tbl_customerdetails 
                 (fname, lname, gender, address, email, pnumber, username, password, image, status, otp, dob) 
                 VALUES 
                 ('$fname', '$lname', '$gender', '$address', '$email', '$contact', '$username', '$pass', '$imagepath', '$status', '$otp', '$dob')";

    $result = $conn->query($insertsql);

    if ($result) {
        // Send verification email
        if(send_verification($fullname, $email, $otp)) {
            // Log the registration
            $user_id = $conn->insert_id;
            $action = "New registration: " . $username;
            $log_sql = "INSERT INTO tbl_logs (Action, Datetime, user_id) VALUES ('$action', NOW(), '$user_id')";
            $conn->query($log_sql);
            
            // Success message with SweetAlert
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Registration complete. Please check your email for verification.",
                    icon: "success",
                    confirmButtonColor: "#102E53"
                }).then(() => {
                    window.location.href = "verifyotp.php";
                });
            </script>';
            exit();
        } else {
            echo '<script>
                Swal.fire({
                    title: "Warning!",
                    text: "Account created but verification email failed to send. Please contact support.",
                    icon: "warning",
                    confirmButtonColor: "#102E53"
                });
            </script>';
        }
    } else {
        $error = $conn->error;
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Registration failed: ' . addslashes($error) . '",
                icon: "error",
                confirmButtonColor: "#102E53"
            });
        </script>';
    }
}
?>
