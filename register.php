<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="col-md-6 p-0">
          <img src="images/main.jpg" alt="Hotel Room" class="w-100 h-100" style="object-fit: cover;">
        </div>

        <!-- Form Section -->
        <div class="col-md-6 d-flex flex-column justify-content-center form-section">
          <h3 class="fw-bold mb-4">Create your Account</h3>
          
          <form action="signup.php" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" class="form-control" name="first_name">
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" class="form-control" name="last_name">
              </div>
            </div>

            <div class="mb-3">
              <label>Phone Number</label>
              <input type="text" class="form-control" name="phone">
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" class="form-control" name="email">
            </div>

            <div class="mb-3">
              <label>Address</label>
              <input type="text" class="form-control" name="address">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Date of Birth</label>
                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name="dob">
              </div>
              <div class="col-md-6 mb-3">
                <label>Gender</label>
                <div class="gender-options">
                  <input type="radio" name="gender" value="Male"> Male
                  <input type="radio" name="gender" value="Female"> Female
                  <input type="radio" name="gender" value="Others"> Others
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label>Username</label>
              <input type="text" class="form-control" name="username">
            </div>

            <div class="mb-4">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>

            <div class="mb-3 text-center">
              <button type="submit" class="btn btn-custom w-100">Sign up</button>
            </div>

            <div class="text-center">
              Already have an account? <a href="login.html" class="text-dark fw-bold">Log in now.</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
