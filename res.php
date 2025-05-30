<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Room Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      /*  image */
      .room-image-container {
        height: 500px; 
      }
      
      /*  white bg */
      .room-details-container {
        height: 500px; 
      }

      .room-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .divider {
        border-top: 3px solid #202e53;
        width: 100px;
        margin: 20px auto;
      }
      
      .amenity-icon {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
        margin: 10px;
      }
      .amenities-container {
        display: flex;
        justify-content: center;
        margin: 10px 0;
        flex-wrap: wrap;
      }
      .amenity-item {
        text-align: center;
        margin: 0 10px;
      }
      .book-now-btn {
        background-color: #202E53;
        color: white;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 4px;
        margin: 10px auto;
        display: block;
        width: fit-content;
        transition: background-color 0.3s;
      }
      .book-now-btn:hover {
        background-color: #3a4a7a;
      }
      .content-wrapper {
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
      }
      .room-description {
        margin-bottom: 15px;
      }
    </style>
  </head>
  <body style="background-color: #BED4C3; margin: 0;">

    <div class="container py-4">
      <!-- Header Section -->
      <div class="text-center mb-5">
        <h1 class="display-4 fw-light" style="color: #202e53;">DISCOVER YOUR PERFECT STAY</h1>
        <p class="lea" style="color: #202e53;">Discover our exquisite collection of Classic, Premier, and Deluxe Rooms—each meticulously crafted to provide the perfect retreat. Enjoy designed spaces, generous layouts for relaxation, and flexible pricing tailored to your preferences.</p>
        <div class="divider"></div>
      </div>
      
      <div class="row g-0">
        <!-- classic room image -->
        <div class="col-lg-6 room-image-container">
          <img src="classic.png" class="room-image" alt="Classic Room">
        </div>

        <!-- classic room deets -->
        <div class="col-lg-6 room-details-container" style="background-color: white;">
          <div class="content-wrapper">
            <div>
              <h1 style="color: #202E53; font-weight: bold;">CLASSIC ROOM</h1>
              <p class="room-description">Designed for a serene and refreshing escape, the Classic Room invites you to unwind in an atmosphere of comfort and charm. Whether you're here for a peaceful retreat or a cozy weekend getaway, this room offers the perfect balance of relaxation and style.</p>
              <ul class="pb-2">
                <li><strong>Classic Room:</strong> 23 sqm</li>
                <li><strong>Price per Night:</strong> ₱3,800</li>
              </ul>

              <!-- amenities icons -->
              <div class="amenities-container">
                <div class="amenity-item">
                    <img src="queen.png" alt="Queen Bed" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Queen Bed</p>
                  </div>
                  <div class="amenity-item">
                    <img src="twin.png" alt="Twin Bed" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Twin Bed</p>
                  </div>
                  <div class="amenity-item">
                    <img src="minibar.png" alt="Minibar" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Minibar</p>
                  </div>
                  <div class="amenity-item">
                      <img src="safe.png" alt="In-room Safe" class="amenity-icon">
                      <p style="color: #ce6b6b; font-weight: bold;">In-room Safe</p>
                    </div>
              </div>
            </div>
            
            <!-- book Now Button -->
            <div class="mt-2">
              <button class="book-now-btn rounded-0" style="font-weight: bold;">Book now</button>
            </div>
          </div>
        </div>  
      </div>

    
      <div class="row g-0 pt-5">
        <!-- premier room image -->
        <div class="col-lg-6 room-image-container">
          <img src="premier.png" class="room-image" alt="Premier Room">
        </div>

        <!-- premier room deets -->
        <div class="col-lg-6 room-details-container" style="background-color: white;">
          <div class="content-wrapper">
            <div>
              <h1 style="color: #202E53; font-weight: bold;">PREMIER SUITE</h1>
              <p class="room-description">Experience elevated comfort and elegance in the Premier Suite. With its sophisticated design, premium finishes, and thoughtful layout, this room offers a luxurious stay that blends style and relaxation.</p>
              <ul class="pb-2">
                <li><strong>Classic Room:</strong> 25 sqm</li>
                <li><strong>Price per Night:</strong> ₱5,200</li>
              </ul>

              <!-- amenities icons -->
              <div class="amenities-container">
                <div class="amenity-item">
                  <img src="queen.png" alt="Queen Bed" class="amenity-icon">
                  <p style="color: #ce6b6b; font-weight: bold;">Queen Bed</p>
                </div>
                <div class="amenity-item">
                  <img src="twin.png" alt="Twin Bed" class="amenity-icon">
                  <p style="color: #ce6b6b; font-weight: bold;">Twin Bed</p>
                </div>
                <div class="amenity-item">
                  <img src="minibar.png" alt="Minibar" class="amenity-icon">
                  <p style="color: #ce6b6b; font-weight: bold;">Minibar</p>
                </div>
                <div class="amenity-item">
                    <img src="safe.png" alt="In-room Safe" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">In-room Safe</p>
                  </div>
                  <div class="amenity-item">
                    <img src="city.png" alt="City View" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">City View</p>
                  </div>
              </div>
            </div>
            
            <!-- book Now Button -->
            <div class="mt-2">
              <button class="book-now-btn rounded-0" style="font-weight: bold;">Book now</button>
            </div>
          </div>
        </div>


            
      <div class="row g-0 pt-5">
        <!-- classic room image -->
        <div class="col-lg-6 room-image-container">
          <img src="deluxe.png" class="room-image" alt="Classic Room">
        </div>

        <!-- classic room deets -->
        <div class="col-lg-6 room-details-container" style="background-color: white;">
          <div class="content-wrapper">
            <div>
              <h1 style="color: #202E53; font-weight: bold;">DELUXE SUITE</h1>
              <p class="room-description">Blending sophistication with convenience, the Deluxe Suite offers a slightly larger space perfect for both relaxation and productivity. Ideal for travelers who desire comfort and modern amenities without excess.</p>
              <ul class="pb-2">
                <li><strong>Classic Room:</strong> 27 sqm</li>
                <li><strong>Price per Night:</strong> ₱7,500</li>
              </ul>

              <!-- amenities Icons -->
              <div class="amenities-container">
                <div class="amenity-item">
                    <img src="queen.png" alt="Queen Bed" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Queen Bed</p>
                  </div>
                  <div class="amenity-item">
                    <img src="twin.png" alt="Twin Bed" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Twin Bed</p>
                  </div>
                  <div class="amenity-item">
                    <img src="minibar.png" alt="Minibar" class="amenity-icon">
                    <p style="color: #ce6b6b; font-weight: bold;">Minibar</p>
                  </div>
                  <div class="amenity-item">
                      <img src="safe.png" alt="In-room Safe" class="amenity-icon">
                      <p style="color: #ce6b6b; font-weight: bold;">In-room Safe</p>
                    </div>
                    <div class="amenity-item">
                      <img src="city.png" alt="City View" class="amenity-icon">
                      <p style="color: #ce6b6b; font-weight: bold;">City View</p>
                    </div>
                    <div class="amenity-item">
                      <img src="extra.png" alt="Extra Bed" class="amenity-icon">
                      <p style="color: #ce6b6b; font-weight: bold;">Extra Bed</p>
                    </div>
              </div>
            </div>
            
            <!-- book Now Button -->
            <div class="mt-2">
              <button class="book-now-btn rounded-0" style="font-weight: bold;">Book now</button>
            </div>
          </div>
        </div>



        
      </div>
        
      </div>


    </div>

       <!-- footer -->
       <style>
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
            margin-bottom: 1rem;
        }
        .footer-logo-text {
            font-size: 1.8rem;
            font-weight: 600;
        }
        .hotel-logo {
            height: 80px;
            border: 1px solid #202E53;
            margin-right: 1rem;
        }
    </style>

<footer class=" py-4" style="background-color: #4A929E;">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- logo and hotel name -->
            <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                    <img src="bblogo.png" alt="Logo" class="me-3 rounded-1" style="height: 80px; border: 1px solid #202E53;">
                    <div class="footer-logo" style="font-size: 1.8rem; font-weight: 600;">The Bloom & Belle Hotel</div>
                </div>
            </div>

<!-- navigation Links -->
<div class="col-md-4 mb-4 mb-md-0 d-flex justify-content-center">
    <div class="footer-links text-start"> 
        <a href="index.html" class="d-block mb-2">Home</a>
        <a href="#" class="d-block mb-2">Profile</a>
        <a href="login.html" class="d-block mb-2">Login</a>
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
  </body>
</html>
