<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Bloom & Belle Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
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

      .hover-move {
        transition: transform 0.3s ease;
      }

      .hover-move:hover {
        transform: scale(1.05);
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
        align-items: center; /* Vertical alignment */
    }

    .footer-logo-icon {
        font-size: 3rem;
        color: white;
        margin-right: 1rem; /* Same as Bootstrap's me-3 */
    }

    .footer-logo-text {
        font-size: 1.8rem;
        font-weight: 600;
        color: white;
        line-height: 1.2; /* Tighter spacing */
    }
      .hotel-logo {
        height: 80px;
        border: 1px solid #202E53;
        margin-right: 1rem;
      }
    </style>
</head>

  <body style="margin: 0; overflow-x: hidden;">

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

      <!-- banner -->
      <div class="position-relative w-100" style="height: 91vh; background: url('banner.png') no-repeat center center/cover;">
        
        <!-- text on banner -->
        <div class="position-absolute start-0 text-white text-start ps-5 mt-5" style="top: 75%; transform: translateY(-50%);">
          <h3 class="fw-semibold">YOUR RELAXING STAY AWAITS</h3>
          <h1 class="fw-bold display-4">WELCOME TO THE BLOOM & BELLE HOTEL</h1>
        </div>
    
            </div>
          </form>
        </div>
      </div>

      <!-- right image -->
      <div class="row">
        <div class="col-6 mt-5 p-5">
          <img src="aboutus.png" style="width: 100%; height: 450px; object-fit: cover;">
        </div>
        <!-- about us -->
        <div class="col-6 mt-5 p-5">
          <h1 class="display-4" style="color: #202E53; font-weight: 700;">YOUR COZY ESCAPE<br>IN THE CITY</h1>     
          <p style="color: #202E53;">The Bloom & Belle Hotel is a charming sanctuary in the heart of Manila, where comfort meets elegance. We take pride in creating a relaxing and welcoming atmosphere for all our guests, whether you're visiting for a weekend getaway, a business trip, or a special celebration. Our beautifully appointed rooms, attentive staff, and calming ambiance are designed to help you unwind, recharge, and enjoy every moment of your stay. At Bloom & Belle, it's not just about staying—it's about feeling at home, away from home.</p>
        </div>
      </div>

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
                <img src="main1.png" alt="Easy Booking" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
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
                <img src="main2.png" alt="Cozy Room" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
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
                <img src="main5.png" alt="Scenic Location" class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid white;">
              </div>
              <h4 class="text-white text-center fw-bold mb-3">SCENIC LOCATION</h4>
              <p class="text-white text-center mb-0">
                Surrounded by nature's beauty with breathtaking views — the perfect setting for both relaxation and adventure.
              </p>
            </div>
          </div>
        </div>
      </section>

      <div class="row align-items-center justify-content-between px-3">
        <!-- label -->
        <div class="col-md-8 col-sm-12 p-5">
          <h1 class="display-4 mb-0" style="color: #202E53; font-weight: 700;"> UNWIND BY NIGHT,<br>AWAKEN WITH CALM</h1>     
        </div>

        <!-- button -->
        <div class="col-md-4 col-sm-12 p-5 text-md-end text-sm-center">
          <button type="submit" name="view" class="btn text-white rounded-0" style="background-color: #202E53; font-size: 1rem; font-weight: bold; padding: 12px 36px;"> View all rooms </button>
        </div>
      </div>

      <!-- room pics -->
      <div class="row g-3 px-3 pb-5 justify-content-center">
        <!-- pic 1 -->
        <div class="col-md-4 d-flex justify-content-center">
          <div class="position-relative w-75">
            <img src="bed1.png" class="hover-move w-100" style="height: 500px; object-fit: cover;">
            <div class="position-absolute bottom-0 start-0 text-white p-4" style="background-color: rgba(0,0,0,0); font-weight: bold; font-size: 24px;"> CLASSIC ROOM</div>
          </div>
        </div>
      
        <!-- pic 2 -->
        <div class="col-md-4 d-flex justify-content-center">
          <div class="position-relative w-75">
            <img src="bed2.png" class="hover-move w-100" style="height: 500px; object-fit: cover;">
            <div class="position-absolute bottom-0 start-0 text-white p-4" style="background-color: rgba(0,0,0,0); font-weight: bold; font-size: 24px;"> PREMIERE SUITE </div>
          </div>
        </div>
      
        <!-- pic 3 -->
        <div class="col-md-4 d-flex justify-content-center">
          <div class="position-relative w-75">
            <img src="bed3.png" class="hover-move w-100" style="height: 500px; object-fit: cover;">
            <div class="position-absolute bottom-0 start-0 text-white p-4" style="background-color: rgba(0,0,0,0); font-weight: bold; font-size: 24px;"> DELUXE SUITE</div>
          </div>
        </div>
      </div>

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

    <script>
    function changeValue(id, delta) {
        const input = document.getElementById(id);
        let value = parseInt(input.value) || 1;
        value += delta;
        if (value < 1) return;
        input.value = value;
    }
      
      // date range
      new Litepicker({
        element: document.getElementById('date-range'),
        singleMode: false, //range selection
        format: 'DD MMM YYYY',
        numberOfMonths: 2,
        numberOfColumns: 2,
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
