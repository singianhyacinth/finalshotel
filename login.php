<?php
require_once "dbaseconnection.php";

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $query = "SELECT * FROM tbl_customerdetails WHERE (username = ? OR email = ?) AND status = 'Active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check MD5 password (since your DB uses MD5)
        if (isset($user['password']) && md5($password) === $user['password']) {

            // Set session variables
            $_SESSION['user_id'] = $user['account_id'] ?? null;
            $_SESSION['username'] = $user['username'] ?? '';
            $_SESSION['role'] = $user['role'] ?? 'customer';
            $_SESSION['name'] = ($user['fname'] ?? '') . ' ' . ($user['lname'] ?? '');
            $_SESSION['img_path'] = $user['image'] ?? '';

            // Log the login action
            $logssql = "INSERT INTO tbl_logs (user_id, action, datetime) VALUES (?, 'Logged In', NOW())";
            $logstmt = $conn->prepare($logssql);
            $logstmt->bind_param("i", $_SESSION['user_id']);
            $logstmt->execute();

            // Redirect based on role
            switch (strtolower($_SESSION['role'])) {
                case 'admin':
                case 'employee':
                case 'customer':
                    header("Location: dashboard.php");
                    exit();
                default:
                    header("Location: login.php?error=invalidrole");
                    exit();
            }
        }
    }

    // Login failed
    echo '<script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid username or password",
            showConfirmButton: false,
            timer: 1500
        });
    </script>';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Bloom & Belle Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      
      .nav-brand {
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
      }
      
      footer {
        background-color: #4A929E;
        padding: 40px 0;
      }
      
      .footer-logo {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #ffffff;
      }
      
      .footer-links a {
        display: block;
        margin-bottom: 8px;
        color: #ffffff;
        text-decoration: none;
        font-size: 12px;
      }
      
      .footer-links a:hover {
        color: #202E53;
      }

      .footer-contact {
        color: #ffffff;
        font-size: 12px;
      }

      .footer-brand-container {
        display: flex;
        align-items: center;
      }

      .footer-logo-icon {
        font-size: 3rem;
        color: white;
        margin-right: 1rem; 
      }

      .footer-logo-text {
        font-size: 1.8rem;
        font-weight: 600;
        color: white;
        line-height: 1.2; 
      }
      
      .password-toggle {
        position: relative;
      }
      
      .password-toggle-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
      }
    </style>
  </head>
  <body style="background-color: #BED4C3; margin: 0;">

    <div class="container-fluid p-0 m-0">

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
                  <a class="nav-link active" href="finalindex.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="accom.html">Accommodations</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contactus.html">Contact Us</a>
                </li>
              </ul>
              <button class="btn btn-outline-light">
                <i class="bi bi-person-circle me-1"></i> Login
              </button>
            </div>
          </div>
        </nav>

    <div class="container-fluid p-0 m-0">

      <div class="row">
        <!-- image -->
        <div class="col-6 p-0" style="height: 68vh;">
          <img src="loginn.png" alt="Login Background" class="w-100 h-100" style="object-fit: cover;">            
        </div>
        
        <!-- log in -->
        <div class="col-6 px-5 d-flex flex-column justify-content-center" style="height: 68vh;">
          <form action="login.php" method="post">
            <h2 class="text-center" style="color: #202E53; font-weight: bold;">Log in to your account.</h2>
            
            <div class="mb-3">
              <label class="form-label" style="color: #202E53;" for="username">Email/Username</label>
              <input type="text" name="username" id="username" class="form-control rounded-0" style="border: 1px solid #202E53;" required>
            </div>
            
            <div class="mb-3 password-toggle">
              <label class="form-label" style="color: #202E53;" for="password">Password</label>
              <input type="password" name="pass" id="password" class="form-control rounded-0" style="border: 1px solid #202E53;" required>
              <span class="password-toggle-icon" onclick="togglePassword()" style="position: absolute; right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer; color: #aaa; font-size: 1rem; opacity: 0.7;">Show</span>            </div>
            
            <a href="#" class="d-block mb-3" style="color: #202E53; text-decoration: none;">Forgot password?</a>
            
            <input type="submit" value="Log in" name="login" class="btn btn-block w-100 text-white rounded-0 mb-3" style="background-color: #202E53; font-weight: bold;">
            
            <a href="register.php" class="d-block" style="color: #202E53; text-decoration: none;">
            Don't have an account yet? <span style="text-decoration: none; border-bottom: 1px solid #202E53;">Sign up now</span>.
            </a>          
        </form>
        </div>
      </div>
    </div>

    <!-- footer -->
    <footer class="py-4" style="background-color: #4A929E;">
      <div class="container">
        <div class="row align-items-center">
          <!-- logo and hotel name -->
          <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
            <div class="footer-brand-container">
              <i class="bi bi-flower1 footer-logo-icon"></i>
              <div class="footer-logo-text">The Bloom & Belle Hotel</div>
            </div>
          </div>

          <!-- navigation Links -->
          <div class="col-md-4 mb-4 mb-md-0 d-flex justify-content-center">
            <div class="footer-links text-start"> 
              <a href="finalindex.php" class="d-block mb-2">Home</a>
              <a href="#" class="d-block mb-2">Profile</a>
              <a href="login.php" class="d-block mb-2">Login</a>
              <a href="contactus.html" class="d-block mb-2">Contact Us</a>
              <a href="accom.html" class="d-block mb-2">Accommodations</a>
            </div>
          </div>
          
          <!-- contact info with socmed -->
          <div class="col-md-4">
            <div class="footer-contact text-start">
              <!-- socmed icons -->
              <div class="social-media mb-3">
                <a href="#" class="mx-2"><img src="fb.png" alt="Facebook" style="height: 30px;"></a>
                <a href="#" class="mx-2"><img src="ig.png" alt="Instagram" style="height: 30px;"></a>
                <a href="#" class="mx-2"><img src="tt.png" alt="Tiktok" style="height: 30px;"></a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
      function togglePassword() {
        const passwordField = document.getElementById('password');
        if (passwordField.type === 'password') {
          passwordField.type = 'text';
        } else {
          passwordField.type = 'password';
        }
      }

      // Show activation success message if redirected from verifyotp
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('activation') && urlParams.get('activation') === 'success') {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Account activated successfully!",
          text: "You can now log in with your credentials",
          showConfirmButton: false,
          timer: 3000
        });
      }
    </script>
  </body>
</html>
