<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reservation Form Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #BED4C3;
      font-family: Arial, sans-serif;
    }
    .container-box {
      background-color: white;
      padding: 30px;
      border: 1px solid #ccc;
    }
    h1, h4, h5, label {
      color: #202E53;
    }
    .price-summary {
      border-top: 1px solid #000;
      margin-top: 20px;
      padding-top: 20px;
    }
    .reserve-btn {
      background-color: #202E53;
      color: white;
      font-weight: bold;
      border: none;
      padding: 10px;
      width: 100%;
    }
    .form-check {
      margin-bottom: 10px;
    }
    .form-check label {
      font-size: 14px;
    }
    .form-check-input {
      margin-top: 5px;
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

  <div class="container py-5">
    <h1 class="text-center fw-bold mb-5">RESERVATION FORM PAGE</h1>
    <div class="row g-4">
      <!-- Left Section -->
      <div class="col-md-8 container-box">
        <h4 class="fw-bold mb-4">Sunset Breeze Villa</h4>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Check-in Date & Time</label>
            <input type="date" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Check-Out Date & Time</label>
            <input type="date" class="form-control">
          </div>
        </div>

        <div class="mb-3 d-flex align-items-center gap-3">
          <label class="mb-0">Night</label>
          <button type="button" class="btn btn-outline-secondary btn-sm">+</button>
          <span>2</span>
          <button type="button" class="btn btn-outline-secondary btn-sm">−</button>
        </div>

        <p class="mb-1">Lead Guest: <strong>Mikaela Angela L. Muldong</strong></p>
        <p>Pax: 26</p>

        <div class="mb-3">
          <label for="specialRequest" class="form-label">Special Request</label>
          <textarea class="form-control" id="specialRequest" rows="4"></textarea>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="policyCheck">
          <label class="form-check-label" for="policyCheck">
            I have read and agree to the <a href="#">Rules and Policy</a>.
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="termsCheck">
          <label class="form-check-label" for="termsCheck">
            I have read and agree to the 
            <a href="#">Terms and Conditions (including cancellation policy)</a>, the Shangri-La Circle 
            <a href="#">Terms and Conditions</a>, the 
            <a href="#">Privacy Policy</a> and the 
            <a href="#">Cookies Policy</a>.
          </label>
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-md-4 container-box">
        <h4 class="fw-bold">Charges</h4>
        <div class="mb-2 d-flex justify-content-between">
          <span>Original Price:</span>
          <span>1,000</span>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <span>Total Room Price:</span>
          <span>2,000</span>
        </div>

        <hr>

        <h5 class="fw-bold mt-4">Mode of Payment</h5>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="paymentMode" id="digital" value="digital">
          <label class="form-check-label" for="digital">
            Digital Payment
          </label>
        </div>
        <input type="text" class="form-control mb-3" placeholder="Enter digital payment ID">

        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="paymentMode" id="card" value="card">
          <label class="form-check-label" for="card">
            Credit/Debit Card
          </label>
        </div>
        <div class="row g-2 mb-4">
          <div class="col-8">
            <input type="text" class="form-control" placeholder="Card Number">
          </div>
          <div class="col-4">
            <input type="text" class="form-control" placeholder="CVC/CVV">
          </div>
        </div>

        <div class="price-summary d-flex justify-content-between fw-bold">
          <span>Total Price:</span>
          <span>2,000</span>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <button class="reserve-btn">Reserve</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
