<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reservation Form Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #BED4C3;
      font-family: Arial, sans-serif;
    }
    .container-box {
      background-color: white;
      padding: 30px;
      border: 1px solid #ccc;
      border-radius: 8px;
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
      border-radius: 5px;
      transition: all 0.3s;
    }
    .reserve-btn:hover {
      background-color: #151f3d;
      transform: translateY(-2px);
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
    .room-type-card {
      border: 2px solid transparent;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: all 0.3s;
    }
    .room-type-card:hover {
      background-color: #f8f9fa;
    }
    .room-type-card.selected {
      border-color: #4a929e;
      background-color: #f0f8ff;
    }
    .room-availability {
      font-size: 12px;
      background-color: #4a929e;
      color: white;
      padding: 2px 8px;
      border-radius: 10px;
      margin-left: 10px;
    }
    .price-container {
      display: flex;
      align-items: center;
      justify-content: flex-end;
    }
    .unavailable .room-availability {
      background-color: #ce6b6b;
    }
    :root {
      --primary-color: #4a929e;
      --secondary-color: #ce6b6b;
      --dark-color: #202e53;
      --light-color: #bed4c3;
    }
    .is-invalid {
      border-color: var(--secondary-color);
    }
    .invalid-feedback {
      color: var(--secondary-color);
    }
    .unavailable {
      opacity: 0.6;
      pointer-events: none;
    }
    .amenities-container {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
    }
    .amenity-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .room-highlight {
      animation: highlight 2s ease;
    }
    @keyframes highlight {
      0% { background-color: rgba(74, 146, 158, 0.3); }
      100% { background-color: transparent; }
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
    <form id="reservationForm" novalidate>
      <div class="row g-4">
        <!-- Left Section -->
        <div class="col-md-8 container-box">
          <h4 class="fw-bold mb-4">Select Your Room Type</h4>
          
          <!-- Room Type Selection -->
          <div class="mb-4">
            <div class="form-check room-type-card" id="classicRoomCard">
              <input class="form-check-input" type="radio" name="roomType" id="classicRoom" value="classic" required>
              <label class="form-check-label w-100" for="classicRoom">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5>Classic Room</h5>
                    <p class="mb-1">Comfortable standard accommodation with essential amenities</p>
                  </div>
                  <div class="price-container">
                    <span class="fw-bold">₱3,800</span>
                    <span class="room-availability">5 available</span>
                  </div>
                </div>
              </label>
            </div>
            
            <div class="form-check room-type-card" id="premierRoomCard">
              <input class="form-check-input" type="radio" name="roomType" id="premierRoom" value="premier">
              <label class="form-check-label w-100" for="premierRoom">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5>Premier Suite</h5>
                    <p class="mb-1">Spacious suite with premium amenities and city views</p>
                  </div>
                  <div class="price-container">
                    <span class="fw-bold">₱5,200</span>
                    <span class="room-availability">5 available</span>
                  </div>
                </div>
              </label>
            </div>
            
            <div class="form-check room-type-card" id="deluxeRoomCard">
              <input class="form-check-input" type="radio" name="roomType" id="deluxeRoom" value="deluxe">
              <label class="form-check-label w-100" for="deluxeRoom">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5>Deluxe Suite</h5>
                    <p class="mb-1">Luxurious accommodation with premium services and panoramic views</p>
                  </div>
                  <div class="price-container">
                    <span class="fw-bold">₱7,500</span>
                    <span class="room-availability">5 available</span>
                  </div>
                </div>
              </label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="checkIn" class="form-label">Check-in Date</label>
              <input type="date" class="form-control" id="checkIn" name="checkIn" required>
              <div class="invalid-feedback">
                Please select a check-in date.
              </div>
            </div>
            <div class="col-md-6">
              <label for="checkOut" class="form-label">Check-Out Date</label>
              <input type="date" class="form-control" id="checkOut" name="checkOut" required>
              <div class="invalid-feedback">
                Please select a check-out date.
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="guestName" class="form-label">Lead Guest Name</label>
            <input type="text" class="form-control" id="guestName" name="guestName" required>
            <div class="invalid-feedback">
              Please enter guest name.
            </div>
          </div>

          <div class="mb-3">
            <label for="pax" class="form-label">Number of Guests</label>
            <input type="number" class="form-control" id="pax" name="pax" value="1" min="1" max="4" required>
            <div class="invalid-feedback">
              Please enter number of guests (1-4).
            </div>
          </div>

          <!-- Additional Amenities Section -->
          <div class="amenities-container">
            <h5 class="fw-bold mb-3">Additional Amenities</h5>
            
            <div class="amenity-item">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="extraBed" name="amenities" value="extraBed">
                <label class="form-check-label" for="extraBed">Extra Bed (₱800)</label>
              </div>
              <span>₱800</span>
            </div>
            
            <div class="amenity-item">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="massage" name="amenities" value="massage">
                <label class="form-check-label" for="massage">Massage (₱1,000)</label>
              </div>
              <span>₱1,000</span>
            </div>
            
            <div class="amenity-item">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="laundry" name="amenities" value="laundry">
                <label class="form-check-label" for="laundry">Laundry Service (₱200/kg)</label>
              </div>
              <div>
                <input type="number" class="form-control form-control-sm" id="laundryKilos" name="laundryKilos" min="1" max="10" style="width: 70px;" disabled>
              </div>
            </div>
            
            <div class="amenity-item">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="breakfast" name="amenities" value="breakfast">
                <label class="form-check-label" for="breakfast">Breakfast Buffet (₱600/person)</label>
              </div>
              <div>
                <input type="number" class="form-control form-control-sm" id="breakfastPersons" name="breakfastPersons" min="1" max="10" style="width: 70px;" disabled>
              </div>
            </div>
            
            <div class="amenity-item">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gym" name="amenities" value="gym">
                <label class="form-check-label" for="gym">Gym Access (₱300/person)</label>
              </div>
              <div>
                <input type="number" class="form-control form-control-sm" id="gymPersons" name="gymPersons" min="1" max="10" style="width: 70px;" disabled>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="specialRequest" class="form-label">Special Request</label>
            <textarea class="form-control" id="specialRequest" name="specialRequest" rows="4"></textarea>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="policyCheck" name="policyCheck" required>
            <label class="form-check-label" for="policyCheck">
              I have read and agree to the <a href="#">Rules and Policy</a>.
            </label>
            <div class="invalid-feedback">
              You must agree to the rules and policy.
            </div>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="termsCheck" name="termsCheck" required>
            <label class="form-check-label" for="termsCheck">
              I have read and agree to the 
              <a href="#">Terms and Conditions (including cancellation policy)</a>, the Shangri-La Circle 
              <a href="#">Terms and Conditions</a>, the 
              <a href="#">Privacy Policy</a> and the 
              <a href="#">Cookies Policy</a>.
            </label>
            <div class="invalid-feedback">
              You must agree to the terms and conditions.
            </div>
          </div>
        </div>

        <!-- Right Section -->
        <div class="col-md-4 container-box">
          <h4 class="fw-bold">Booking Summary</h4>
          <div class="mb-2">
            <small>Room Type:</small>
            <div id="selectedRoomType" class="fw-bold">Select a room</div>
          </div>
          <div class="mb-2">
            <small>Room Number:</small>
            <div id="assignedRoomNumber" class="fw-bold">Will be assigned after booking</div>
          </div>
          <div class="mb-2 d-flex justify-content-between">
            <span>Price per night:</span>
            <span id="roomPrice">-</span>
          </div>
          <div class="mb-3 d-flex justify-content-between">
            <span>Total Room Price:</span>
            <span id="totalPrice">-</span>
          </div>

          <!-- Amenities Summary -->
          <div id="amenitiesSummary" class="mb-3" style="display: none;">
            <h5 class="fw-bold mt-4">Additional Amenities</h5>
            <div id="amenitiesList"></div>
          </div>

          <hr>

          <h5 class="fw-bold mt-4">Mode of Payment</h5>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="paymentMode" id="gcash" value="gcash" required>
            <label class="form-check-label" for="gcash">
              GCash
            </label>
          </div>
          <div class="mb-3" id="gcashPaymentField" style="display: none;">
            <div class="mb-2">
              <label class="form-label">GCash Account Name</label>
              <input type="text" class="form-control" id="gcashName" name="gcashName" placeholder="Juan Dela Cruz">
              <div class="invalid-feedback">
                Please enter your GCash account name.
              </div>
            </div>
            <div class="mb-2">
              <label class="form-label">GCash Mobile Number</label>
              <input type="text" class="form-control" id="gcashNumber" name="gcashNumber" placeholder="09XXXXXXXXX">
              <div class="invalid-feedback">
                Please enter your GCash mobile number.
              </div>
            </div>
          </div>

          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="paymentMode" id="card" value="card">
            <label class="form-check-label" for="card">
              Credit/Debit Card
            </label>
          </div>
          <div class="mb-4" id="cardPaymentFields" style="display: none;">
            <div class="mb-2">
              <label class="form-label">Cardholder Name</label>
              <input type="text" class="form-control" id="cardName" name="cardName" placeholder="Juan Dela Cruz">
              <div class="invalid-feedback">
                Please enter cardholder name.
              </div>
            </div>
            <div class="mb-2">
              <label class="form-label">Card Number</label>
              <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456">
              <div class="invalid-feedback">
                Please enter a valid card number.
              </div>
            </div>
            <div class="row g-2">
              <div class="col-8">
                <label class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="cardExpiry" name="cardExpiry" placeholder="MM/YY">
                <div class="invalid-feedback">
                  Please enter expiry date.
                </div>
              </div>
              <div class="col-4">
                <label class="form-label">CVV</label>
                <input type="text" class="form-control" id="cardCvc" name="cardCvc" placeholder="123">
                <div class="invalid-feedback">
                  Please enter CVV code.
                </div>
              </div>
            </div>
          </div>

          <div class="price-summary d-flex justify-content-between fw-bold">
            <span>Total Price:</span>
            <span id="finalPrice">₱0.00</span>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="reserve-btn">Reserve</button>
      </div>
    </form>
  </div>

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-4">
          <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
          <h3 class="mt-3">Reservation Successful!</h3>
          <p class="mt-3">Your reservation for <span id="confirmedRoomType">Classic Room</span> has been confirmed.</p>
          <p>Room Number: <span id="confirmedRoomNumber">101</span></p>
          <p>Total Amount: <span id="confirmedPrice">₱3,800.00</span></p>
          <p>Check-in: <span id="confirmedCheckIn">2023-11-01</span></p>
          <p>Check-out: <span id="confirmedCheckOut">2023-11-02</span></p>
          <p>A confirmation email has been sent to your registered email address.</p>
        </div>
        <div class="modal-footer border-0 justify-content-center">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Database simulation
      const roomDatabase = {
        classic: {
          name: "Classic Room",
          price: 3800,
          totalRooms: 5,
          maxGuests: 4,
          rooms: [101, 102, 103, 104, 105],
          bookings: {}
        },
        premier: {
          name: "Premier Suite",
          price: 5200,
          totalRooms: 5,
          maxGuests: 4,
          rooms: [201, 202, 203, 204, 205],
          bookings: {}
        },
        deluxe: {
          name: "Deluxe Suite",
          price: 7500,
          totalRooms: 5,
          maxGuests: 5,
          rooms: [301, 302, 303, 304, 305],
          bookings: {}
        }
      };

      // Amenities prices
      const amenitiesPrices = {
        extraBed: 800,
        massage: 1000,
        laundry: 200,
        breakfast: 600,
        gym: 300
      };

      const form = document.getElementById('reservationForm');
      const roomPrice = document.getElementById('roomPrice');
      const totalPrice = document.getElementById('totalPrice');
      const finalPrice = document.getElementById('finalPrice');
      const selectedRoomType = document.getElementById('selectedRoomType');
      const assignedRoomNumber = document.getElementById('assignedRoomNumber');
      const confirmedRoomType = document.getElementById('confirmedRoomType');
      const confirmedRoomNumber = document.getElementById('confirmedRoomNumber');
      const confirmedPrice = document.getElementById('confirmedPrice');
      const confirmedCheckIn = document.getElementById('confirmedCheckIn');
      const confirmedCheckOut = document.getElementById('confirmedCheckOut');
      const gcashRadio = document.getElementById('gcash');
      const cardRadio = document.getElementById('card');
      const gcashPaymentField = document.getElementById('gcashPaymentField');
      const cardPaymentFields = document.getElementById('cardPaymentFields');
      const successModal = new bootstrap.Modal(document.getElementById('successModal'));
      const paxInput = document.getElementById('pax');
      const extraBedCheckbox = document.getElementById('extraBed');
      const amenitiesSummary = document.getElementById('amenitiesSummary');
      const amenitiesList = document.getElementById('amenitiesList');
      
      // Current selected room
      let currentRoom = null;
      let amenitiesTotal = 0;
      
      // Initialize room availability display
      updateRoomAvailabilityDisplay();
      
      // Room type selection
      document.querySelectorAll('input[name="roomType"]').forEach(radio => {
        radio.addEventListener('change', function() {
          currentRoom = this.value;
          updatePrices();
          updateGuestLimit();
          
          // Update card styling
          document.querySelectorAll('.room-type-card').forEach(card => {
            card.classList.remove('selected');
          });
          const selectedCard = document.getElementById(`${currentRoom}RoomCard`);
          selectedCard.classList.add('selected');
          selectedCard.classList.add('room-highlight');
          setTimeout(() => {
            selectedCard.classList.remove('room-highlight');
          }, 2000);
        });
      });
      
      // Update guest limit based on room type
      function updateGuestLimit() {
        if (!currentRoom) return;
        const maxGuests = roomDatabase[currentRoom].maxGuests;
        paxInput.max = maxGuests;
        paxInput.nextElementSibling.textContent = `Please enter number of guests (1-${maxGuests}).`;
      }
      
      // Calculate number of nights between dates
      function calculateNights(checkIn, checkOut) {
        const startDate = new Date(checkIn);
        const endDate = new Date(checkOut);
        const diffTime = Math.abs(endDate - startDate);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      }
      
      // Price calculation
      function updatePrices() {
        if (!currentRoom) {
          roomPrice.textContent = '-';
          totalPrice.textContent = '-';
          finalPrice.textContent = '₱0.00';
          return;
        }
        
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        
        if (!checkIn || !checkOut) {
          // If dates aren't selected yet, default to 1 night
          const price = roomDatabase[currentRoom].price;
          roomPrice.textContent = `₱${price.toLocaleString('en-PH')}.00`;
          totalPrice.textContent = `₱${price.toLocaleString('en-PH')}.00`;
          updateFinalPrice();
          return;
        }
        
        const nights = calculateNights(checkIn, checkOut);
        const price = roomDatabase[currentRoom].price;
        const total = nights * price;
        
        roomPrice.textContent = `₱${price.toLocaleString('en-PH')}.00`;
        totalPrice.textContent = `₱${total.toLocaleString('en-PH')}.00`;
        updateFinalPrice();
        selectedRoomType.textContent = roomDatabase[currentRoom].name;
      }
      
      // Update final price including amenities
      function updateFinalPrice() {
        if (!currentRoom) {
          finalPrice.textContent = '₱0.00';
          return;
        }
        
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        let nights = 1;
        
        if (checkIn && checkOut) {
          nights = calculateNights(checkIn, checkOut);
        }
        
        const price = roomDatabase[currentRoom].price;
        const roomTotal = nights * price;
        const finalTotal = roomTotal + amenitiesTotal;
        
        finalPrice.textContent = `₱${finalTotal.toLocaleString('en-PH')}.00`;
      }
      
      // Payment method toggle
      gcashRadio.addEventListener('change', function() {
        if (this.checked) {
          gcashPaymentField.style.display = 'block';
          cardPaymentFields.style.display = 'none';
          // Clear card fields
          document.getElementById('cardName').value = '';
          document.getElementById('cardNumber').value = '';
          document.getElementById('cardExpiry').value = '';
          document.getElementById('cardCvc').value = '';
        }
      });
      
      cardRadio.addEventListener('change', function() {
        if (this.checked) {
          cardPaymentFields.style.display = 'block';
          gcashPaymentField.style.display = 'none';
          // Clear GCash fields
          document.getElementById('gcashName').value = '';
          document.getElementById('gcashNumber').value = '';
        }
      });
      
      // Check room availability for selected dates
      document.getElementById('checkIn').addEventListener('change', checkAvailability);
      document.getElementById('checkOut').addEventListener('change', checkAvailability);
      
      function checkAvailability() {
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        
        if (!checkIn || !checkOut) return;
        
        // Update prices based on new dates
        updatePrices();
        
        // For each room type, check availability
        Object.keys(roomDatabase).forEach(roomType => {
          const available = isRoomAvailable(roomType, checkIn, checkOut);
          const roomCard = document.getElementById(`${roomType}RoomCard`);
          const availabilityBadge = roomCard.querySelector('.room-availability');
          
          if (available.available) {
            roomCard.classList.remove('unavailable');
            availabilityBadge.textContent = `${available.availableRooms} available`;
            availabilityBadge.style.backgroundColor = '#4a929e'; // Available color
          } else {
            roomCard.classList.add('unavailable');
            availabilityBadge.textContent = 'Sold out';
            availabilityBadge.style.backgroundColor = '#ce6b6b'; // Sold out color
            
            // Unselect if currently selected and unavailable
            if (currentRoom === roomType) {
              document.getElementById('classicRoom').checked = false;
              currentRoom = null;
              updatePrices();
              document.querySelectorAll('.room-type-card').forEach(card => {
                card.classList.remove('selected');
              });
            }
          }
        });
      }
      
      function isRoomAvailable(roomType, checkIn, checkOut) {
        const roomData = roomDatabase[roomType];
        const bookedRooms = new Set();
        
        // Convert dates to Date objects for comparison
        const startDate = new Date(checkIn);
        const endDate = new Date(checkOut);
        
        // Check each date in the range
        for (let date = new Date(startDate); date < endDate; date.setDate(date.getDate() + 1)) {
          const dateStr = date.toISOString().split('T')[0];
          if (roomData.bookings[dateStr]) {
            roomData.bookings[dateStr].forEach(room => bookedRooms.add(room));
          }
        }
        
        const availableRooms = roomData.totalRooms - bookedRooms.size;
        return {
          available: availableRooms > 0,
          availableRooms: availableRooms
        };
      }
      
      function updateRoomAvailabilityDisplay() {
        Object.keys(roomDatabase).forEach(roomType => {
          const roomCard = document.getElementById(`${roomType}RoomCard`);
          const availabilityBadge = roomCard.querySelector('.room-availability');
          availabilityBadge.textContent = `${roomDatabase[roomType].totalRooms} available`;
        });
      }
      
      function assignRoom(roomType, checkIn, checkOut) {
        const roomData = roomDatabase[roomType];
        const startDate = new Date(checkIn);
        const endDate = new Date(checkOut);
        
        // Find first available room
        for (const room of roomData.rooms) {
          let isAvailable = true;
          
          // Check if room is booked on any date in the range
          for (let date = new Date(startDate); date < endDate; date.setDate(date.getDate() + 1)) {
            const dateStr = date.toISOString().split('T')[0];
            if (roomData.bookings[dateStr] && roomData.bookings[dateStr].includes(room)) {
              isAvailable = false;
              break;
            }
          }
          
          if (isAvailable) {
            // Book the room for each date
            for (let date = new Date(startDate); date < endDate; date.setDate(date.getDate() + 1)) {
              const dateStr = date.toISOString().split('T')[0];
              if (!roomData.bookings[dateStr]) {
                roomData.bookings[dateStr] = [];
              }
              roomData.bookings[dateStr].push(room);
            }
            return room;
          }
        }
        return null; // No available room (shouldn't happen if we checked availability first)
      }
      
      // Amenities handling
      document.getElementById('extraBed').addEventListener('change', function() {
        if (this.checked && currentRoom) {
          // Increase guest limit by 1 if extra bed is selected
          const maxGuests = roomDatabase[currentRoom].maxGuests + 1;
          paxInput.max = maxGuests;
          paxInput.nextElementSibling.textContent = `Please enter number of guests (1-${maxGuests}).`;
        } else if (currentRoom) {
          // Reset guest limit
          updateGuestLimit();
        }
        updateAmenities();
      });
      
      document.getElementById('laundry').addEventListener('change', function() {
        document.getElementById('laundryKilos').disabled = !this.checked;
        updateAmenities();
      });
      
      document.getElementById('breakfast').addEventListener('change', function() {
        document.getElementById('breakfastPersons').disabled = !this.checked;
        updateAmenities();
      });
      
      document.getElementById('gym').addEventListener('change', function() {
        document.getElementById('gymPersons').disabled = !this.checked;
        updateAmenities();
      });
      
      // Update amenities when quantity inputs change
      document.getElementById('laundryKilos').addEventListener('input', updateAmenities);
      document.getElementById('breakfastPersons').addEventListener('input', updateAmenities);
      document.getElementById('gymPersons').addEventListener('input', updateAmenities);
      
      // Handle other amenities checkboxes
      document.querySelectorAll('input[name="amenities"]').forEach(checkbox => {
        if (checkbox.id !== 'extraBed' && checkbox.id !== 'laundry' && checkbox.id !== 'breakfast' && checkbox.id !== 'gym') {
          checkbox.addEventListener('change', updateAmenities);
        }
      });
      
      function updateAmenities() {
        amenitiesTotal = 0;
        let amenitiesHtml = '';
        
        // Extra Bed
        if (document.getElementById('extraBed').checked) {
          const price = amenitiesPrices.extraBed;
          amenitiesTotal += price;
          amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
            <span>Extra Bed:</span>
            <span>₱${price.toLocaleString('en-PH')}.00</span>
          </div>`;
        }
        
        // Massage
        if (document.getElementById('massage').checked) {
          const price = amenitiesPrices.massage;
          amenitiesTotal += price;
          amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
            <span>Massage:</span>
            <span>₱${price.toLocaleString('en-PH')}.00</span>
          </div>`;
        }
        
        // Laundry
        if (document.getElementById('laundry').checked) {
          const kilos = parseInt(document.getElementById('laundryKilos').value) || 1;
          const price = amenitiesPrices.laundry * kilos;
          amenitiesTotal += price;
          amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
            <span>Laundry Service (${kilos} kg):</span>
            <span>₱${price.toLocaleString('en-PH')}.00</span>
          </div>`;
        }
        
        // Breakfast
        if (document.getElementById('breakfast').checked) {
          const persons = parseInt(document.getElementById('breakfastPersons').value) || 1;
          const price = amenitiesPrices.breakfast * persons;
          amenitiesTotal += price;
          amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
            <span>Breakfast Buffet (${persons} persons):</span>
            <span>₱${price.toLocaleString('en-PH')}.00</span>
          </div>`;
        }
        
        // Gym Access
        if (document.getElementById('gym').checked) {
          const persons = parseInt(document.getElementById('gymPersons').value) || 1;
          const price = amenitiesPrices.gym * persons;
          amenitiesTotal += price;
          amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
            <span>Gym Access (${persons} persons):</span>
            <span>₱${price.toLocaleString('en-PH')}.00</span>
          </div>`;
        }
        
        // Update amenities summary
        if (amenitiesHtml) {
          amenitiesList.innerHTML = amenitiesHtml;
          amenitiesSummary.style.display = 'block';
        } else {
          amenitiesSummary.style.display = 'none';
        }
        
        updateFinalPrice();
      }
      
      // Form validation
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        // Validate main form
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }
        
        // Validate room selection
        if (!currentRoom) {
          alert('Please select a room type');
          return;
        }
        
        // Validate number of guests
        const pax = parseInt(paxInput.value);
        let maxGuests = roomDatabase[currentRoom].maxGuests;
        if (extraBedCheckbox.checked) {
          maxGuests += 1;
        }
        
        if (pax > maxGuests) {
          alert(`Number of guests exceeds the maximum allowed for this room type (${maxGuests}).`);
          return;
        }
        
        // Additional validation for payment methods
        if (gcashRadio.checked) {
          if (!document.getElementById('gcashName').value) {
            document.getElementById('gcashName').classList.add('is-invalid');
            return;
          }
          if (!document.getElementById('gcashNumber').value) {
            document.getElementById('gcashNumber').classList.add('is-invalid');
            return;
          }
        }
        
        if (cardRadio.checked) {
          const cardName = document.getElementById('cardName');
          const cardNumber = document.getElementById('cardNumber');
          const cardExpiry = document.getElementById('cardExpiry');
          const cardCvc = document.getElementById('cardCvc');
          
          if (!cardName.value) {
            cardName.classList.add('is-invalid');
            return;
          }
          if (!cardNumber.value) {
            cardNumber.classList.add('is-invalid');
            return;
          }
          if (!cardExpiry.value) {
            cardExpiry.classList.add('is-invalid');
            return;
          }
          if (!cardCvc.value) {
            cardCvc.classList.add('is-invalid');
            return;
          }
        }
        
        // Check room availability again before booking
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        const availability = isRoomAvailable(currentRoom, checkIn, checkOut);
        
        if (!availability.available) {
          alert('Sorry, the selected room type is no longer available for your dates. Please choose another room or different dates.');
          return;
        }
        
        // Assign a room
        const assignedRoom = assignRoom(currentRoom, checkIn, checkOut);
        if (!assignedRoom) {
          alert('Error assigning a room. Please try again.');
          return;
        }
        
        // Update confirmation modal
        confirmedRoomType.textContent = roomDatabase[currentRoom].name;
        confirmedRoomNumber.textContent = assignedRoom;
        confirmedPrice.textContent = finalPrice.textContent;
        confirmedCheckIn.textContent = checkIn;
        confirmedCheckOut.textContent = checkOut;
        
        // Update UI with assigned room number
        assignedRoomNumber.textContent = assignedRoom;
        
        // If all validations pass
        successModal.show();
        
        // Reset form (but keep room assignment visible)
        form.reset();
        form.classList.remove('was-validated');
        
        // Reset form to default values (except room assignment)
        document.getElementById('classicRoom').checked = false;
        currentRoom = null;
        updatePrices();
        checkAvailability();
        
        // Reset amenities
        amenitiesTotal = 0;
        amenitiesSummary.style.display = 'none';
        document.getElementById('laundryKilos').disabled = true;
        document.getElementById('breakfastPersons').disabled = true;
        document.getElementById('gymPersons').disabled = true;
      });
      
      // Clear validation when user starts typing
      form.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
          this.classList.remove('is-invalid');
        });
      });
      
      // Initialize prices and guest limit
      updatePrices();
      
      // Handle room type from URL parameter
      const urlParams = new URLSearchParams(window.location.search);
      const roomParam = urlParams.get('room');
      if (roomParam && ['classic', 'premier', 'deluxe'].includes(roomParam)) {
        const radio = document.getElementById(`${roomParam}Room`);
        if (radio) {
          radio.checked = true;
          radio.dispatchEvent(new Event('change'));
          
          // Highlight the selected room card
          const selectedCard = document.getElementById(`${roomParam}RoomCard`);
          selectedCard.classList.add('room-highlight');
          setTimeout(() => {
            selectedCard.classList.remove('room-highlight');
          }, 2000);
        }
      }
    });
  </script>
</body>
</html>
