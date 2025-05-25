<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Bloom & Belle Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4a929e;
      --secondary-color: #ce6b6b;
      --dark-color: #202e53;
      --light-color: #bed4c3;
    }
    
    body {
      background-color: var(--light-color);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .nav-brand {
      font-family: 'Georgia', serif;
      letter-spacing: 1px;
    }
    
    .feature-card, .review-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }
    
    .feature-card:hover, .review-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .section-title {
      position: relative;
      margin-bottom: 2rem;
    }
    
    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: var(--secondary-color);
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

  <!-- WHY CHOOSE US -->
  <section class="container my-5 py-4">
    <div class="text-center mb-5">
      <h1 class="fw-bold display-4 section-title" style="color: var(--dark-color);">WHY CHOOSE US?</h1>
      <p class="lead mx-auto" style="max-width: 800px;">
        At <strong>The Bloom & Belle Hotel</strong>, we believe that every stay should be more than just a vacation — it should be an experience to remember. From exceptional service to breathtaking surroundings, we are committed to giving our guests the perfect escape.
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card feature-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="text-center mb-3">
            <img src="images/main1.jpg" alt="Easy Booking" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
          </div>
          <h4 class="text-white text-center fw-bold mb-3">EASY BOOKING</h4>
          <p class="text-white text-center mb-0">
            Flexible packages and a smooth reservation process tailored to your needs with our 24/7 booking system.
          </p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card feature-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="text-center mb-3">
            <img src="images/main2.jpg" alt="Cozy Room" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
          </div>
          <h4 class="text-white text-center fw-bold mb-3">LUXURY ROOMS</h4>
          <p class="text-white text-center mb-0">
            Relax in comfort with our stylish, fully equipped accommodations featuring premium amenities and designer furnishings.
          </p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card feature-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="text-center mb-3">
            <img src="images/main5.jpg" alt="Scenic Location" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
          </div>
          <h4 class="text-white text-center fw-bold mb-3">SCENIC LOCATION</h4>
          <p class="text-white text-center mb-0">
            Surrounded by nature's beauty with breathtaking views — the perfect setting for both relaxation and adventure.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- CUSTOMER REVIEWS -->
  <section class="container my-5 py-4">
    <div class="text-center mb-5">
      <h1 class="fw-bold display-4 section-title" style="color: var(--dark-color);">WHAT OUR GUESTS SAY</h1>
      <p class="lead">Don't just take our word for it - hear from our delighted guests</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card review-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-warning">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <small class="text-white">2 days ago</small>
          </div>
          <p class="text-white mb-4">
            "Absolutely loved our weekend stay! The place is peaceful, the staff were super friendly, and the views were stunning. Will definitely come back."
          </p>
          <div class="d-flex align-items-center">
            <div class="me-3">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle" width="50" height="50" alt="Guest">
            </div>
            <div>
              <h6 class="fw-bold mb-0 text-white">HA YI CHAN</h6>
              <small class="text-white-50">Business Traveler</small>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card review-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-warning">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-half"></i>
            </div>
            <small class="text-white">1 week ago</small>
          </div>
          <p class="text-white mb-4">
            "The attention to detail was remarkable. From the welcome drink to the turndown service, every moment felt special. The spa treatments were divine!"
          </p>
          <div class="d-flex align-items-center">
            <div class="me-3">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle" width="50" height="50" alt="Guest">
            </div>
            <div>
              <h6 class="fw-bold mb-0 text-white">YOON CHEONG</h6>
              <small class="text-white-50">Honeymooners</small>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card review-card p-4 h-100 border-0" style="background-color: var(--secondary-color); border-radius: 20px;">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="text-warning">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <small class="text-white">3 weeks ago</small>
          </div>
          <p class="text-white mb-4">
            "As a frequent traveler, I can confidently say this is one of the best hotels I've experienced. The beds are heavenly and the breakfast buffet is exceptional."
          </p>
          <div class="d-flex align-items-center">
            <div class="me-3">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle" width="50" height="50" alt="Guest">
            </div>
            <div>
              <h6 class="fw-bold mb-0 text-white">HA EUN GYEOL</h6>
              <small class="text-white-50">Frequent Guest</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
