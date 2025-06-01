<?php
include('dbaseconnection.php');

// Database configuration
$host = '127.0.0.1';  // Critical - uses TCP/IP
$dbname = 'ms_db_hotel';
$username = 'root';
$password = '';
$port = 3306;  // Explicit port declaration

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 1. Establish connection
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false  // Important for some setups
        ]
    );
    
    // 2. Verify connection by running a test query
    $stmt = $pdo->query("SELECT 1 AS connection_test");
    $result = $stmt->fetch();
    
    if ($result['connection_test'] == 1) {
        echo "✅ PDO successfully connected via TCP/IP";
        echo "<br>Database version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    } else {
        throw new Exception("Connection test failed");
    }

} catch (PDOException $e) {
    die("<strong> Connection failed:</strong> " . 
        $e->getMessage() . 
        " (Error Code: " . $e->getCode() . ")");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate and process reservation
  $errors = [];
  
  // Required fields
  $required = [
      'user_id', 'room_id', 'checkIn', 'checkOut', 'guestName',
      'paymentMode', 'policyCheck', 'termsCheck'
  ];
  
  foreach ($required as $field) {
      if (empty($_POST[$field])) {
          $errors[] = ucfirst($field) . " is required.";
      }
  }
  
  if (empty($errors)) {
      try {
          // Start transaction
          $pdo->beginTransaction();
          
          // Get room details
          $stmt = $pdo->prepare("SELECT * FROM tbl_room WHERE room_id = ?");
          $stmt->execute([$_POST['room_id']]);
          $room = $stmt->fetch();
          
          if (!$room) {
              throw new Exception("Selected room not found.");
          }
          
          // Calculate number of nights
          $checkIn = new DateTime($_POST['checkIn']);
          $checkOut = new DateTime($_POST['checkOut']);
          $nights = $checkOut->diff($checkIn)->days;
          
          // Calculate room price
          $roomPrice = $room['price_per_use'] * $nights;
          
          // Calculate amenities total
          $amenitiesTotal = 0;
          $amenities = [];
          
          if (!empty($_POST['amenities'])) {
              foreach ($_POST['amenities'] as $amenityId) {
                  $stmt = $pdo->prepare("SELECT * FROM tbl_amenity WHERE amenity_id = ?");
                  $stmt->execute([$amenityId]);
                  $amenity = $stmt->fetch();
                  
                  if (!$amenity) continue;
                  
                  $quantity = 1;
                  
                  // Handle quantity fields
                  if ($amenityId == ($_POST['laundry_amenity_id'] ?? '')) {
                      $quantity = intval($_POST['laundryKilos'] ?? 1);
                  } elseif ($amenityId == ($_POST['breakfast_amenity_id'] ?? '')) {
                      $quantity = intval($_POST['breakfastPersons'] ?? 1);
                  } elseif ($amenityId == ($_POST['gym_amenity_id'] ?? '')) {
                      $quantity = intval($_POST['gymPersons'] ?? 1);
                  }
                  
                  $amenitiesTotal += $amenity['price_per_use'] * $quantity;
                  $amenities[] = [
                      'id' => $amenityId,
                      'name' => $amenity['amenity_name'],
                      'quantity' => $quantity,
                      'price' => $amenity['price_per_use']
                  ];
              }
          }
          
          $totalPrice = $roomPrice + $amenitiesTotal;
          
          // Create reservation
          $stmt = $pdo->prepare("
              INSERT INTO tbl_reservation (
                  user_id, accommodation_id, room_id, check_in_date, check_out_date, 
                  total_price, reservation_status, guest_name, num_guests, special_requests,
                  payment_method, amenities
              ) VALUES (?, ?, ?, ?, ?, ?, 'confirmed', ?, ?, ?, ?, ?)
          ");
          
          $stmt->execute([
              $_POST['user_id'],
              $_POST['accommodation_id'],
              $_POST['room_id'],
              $_POST['checkIn'],
              $_POST['checkOut'],
              $totalPrice,
              $_POST['guestName'],
              $_POST['pax'],
              $_POST['specialRequest'] ?? '',
              $_POST['paymentMode'],
              json_encode($amenities)
          ]);
          
          $reservationId = $pdo->lastInsertId();
          
          // Update room availability
          $stmt = $pdo->prepare("
              UPDATE tbl_room 
              SET availability_status = '1' 
              WHERE room_id = ?
          ");
          $stmt->execute([$_POST['room_id']]);
          
          // Commit transaction
          $pdo->commit();
          
          // Show success message
          $success = true;
          $reservationDetails = [
              'roomType' => $room['room_type'],
              'roomNumber' => $room['room_number'],
              'description' => $room['description'],
              'capacity' => $room['capacity'],
              'price_per_use' => $room['price_per_use'],
              'totalPrice' => $totalPrice,
              'checkIn' => $_POST['checkIn'],
              'checkOut' => $_POST['checkOut']
          ];
          
      } catch (PDOException $e) {
          $pdo->rollBack();
          $errors[] = "Database error: " . $e->getMessage();
      } catch (Exception $e) {
          $pdo->rollBack();
          $errors[] = $e->getMessage();
      }
  }
}

// Helper functions
function calculateNights($checkIn, $checkOut) {
  $start = new DateTime($checkIn);
  $end = new DateTime($checkOut);
  return $end->diff($start)->days;
}

function getRooms() {
  global $pdo;
  $stmt = $pdo->query("SELECT * FROM tbl_room WHERE availability_status = '1'");
  return $stmt->fetchAll();
}

function getAmenities() {
  global $pdo;
  $stmt = $pdo->query("SELECT * FROM tbl_amenity");
  return $stmt->fetchAll();
}

function getRoomById($id) {
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM tbl_room WHERE room_id = ?");
  $stmt->execute([$id]);
  return $stmt->fetch();
}

function getAmenityById($id) {
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM tbl_amenity WHERE amenity_id = ?");
  $stmt->execute([$id]);
  return $stmt->fetch();
}

// Get data from database
$rooms = getRooms();
$amenities = getAmenities();

// Find amenity IDs for special handling
$laundryAmenity = null;
$breakfastAmenity = null;
$gymAmenity = null;

foreach ($amenities as $amenity) {
  if (stripos($amenity['amenity_name'], 'laundry') !== false) {
      $laundryAmenity = $amenity;
  } elseif (stripos($amenity['amenity_name'], 'breakfast') !== false) {
      $breakfastAmenity = $amenity;
  } elseif (stripos($amenity['amenity_name'], 'gym') !== false) {
      $gymAmenity = $amenity;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reservation Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    /* Your existing CSS styles here */
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
    .amenities-table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    .amenities-table th, .amenities-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .amenities-table th {
      background-color: #f8f9fa;
      font-weight: bold;
    }
    .amenities-table tr:hover {
      background-color: #f5f5f5;
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
    
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    
    <?php if (isset($success) && $success): ?>
      <div class="alert alert-success">
        Reservation successful! Your reservation ID is <?php echo $reservationId; ?>
      </div>
    <?php endif; ?>
    
    <form id="reservationForm" method="post" novalidate>
      <input type="hidden" name="user_id" value="1">
      <input type="hidden" name="accommodation_id" value="1">
      <input type="hidden" name="room_id" id="roomIdField">
      <input type="hidden" name="roomTypeName" id="roomTypeNameField">
      <input type="hidden" name="totalPrice" id="totalPriceField">
      <?php if ($laundryAmenity): ?>
        <input type="hidden" name="laundry_amenity_id" value="<?php echo $laundryAmenity['amenity_id']; ?>">
      <?php endif; ?>
      <?php if ($breakfastAmenity): ?>
        <input type="hidden" name="breakfast_amenity_id" value="<?php echo $breakfastAmenity['amenity_id']; ?>">
      <?php endif; ?>
      <?php if ($gymAmenity): ?>
        <input type="hidden" name="gym_amenity_id" value="<?php echo $gymAmenity['amenity_id']; ?>">
      <?php endif; ?>
      
      <div class="row g-4">
        <!-- Left Section -->
        <div class="col-md-8 container-box">
          <h4 class="fw-bold mb-4">Select Your Room Type</h4>
          
          <!-- debug -->
          <?php 
          echo '<div class="alert alert-info"><strong>Debug:</strong> ';
          echo count($rooms) . ' rooms found in database';
          echo '</div>';
          ?>

          <!-- Room Type Selection -->
          <div class="mb-4">
            <?php foreach ($rooms as $room): ?>
              <div class="form-check room-type-card" id="<?php echo htmlspecialchars($room['room_type']); ?>RoomCard">
              <input class="form-check-input" type="radio" name="roomType" 
                  id="<?php echo htmlspecialchars($room['room_type']); ?>Room" 
                  value="<?php echo htmlspecialchars($room['room_type']); ?>"
                  data-room-id="<?php echo $room['room_id']; ?>"
                  data-room-number="<?php echo $room['room_number']; ?>"
                  data-price="<?php echo $room['price_per_use']; ?>"
                  data-max-guests="<?php echo $room['capacity']; ?>"
                  required>

                <label class="form-check-label w-100" for="<?php echo htmlspecialchars($room['room_type']); ?>Room">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <h5><?php echo htmlspecialchars(ucfirst($room['room_type'] ?? '')); ?> Room</h5>
                    <p class="mb-1"><?php echo htmlspecialchars($room['description'] ?? ''); ?></p>
                    </div>
                    <div class="price-container">
                      <span class="fw-bold"><?php echo htmlspecialchars($room['price_per_use'], 2); ?></span>
                      <span class="room-availability">Available</span>
                    </div>
                  </div>
                </label>
              </div>
            <?php endforeach; ?>
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
            <input type="number" class="form-control" id="pax" name="pax" value="1" min="1" required>
            <div class="invalid-feedback">
              Please enter number of guests.
            </div>
          </div>

          <!-- Additional Amenities Section -->
          <div class="amenities-container">
            <h5 class="fw-bold mb-3">Additional Amenities</h5>
            
            <!-- Amenities Table -->
            <table class="amenities-table">
              <thead>
                <tr>
                  <th>Amenity ID</th>
                  <th>Amenity Name</th>
                  <th>Description</th>
                  <th>Price per Use</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($amenities as $amenity): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($amenity['amenity_id']); ?></td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               id="amenity_<?php echo $amenity['amenity_id']; ?>" 
                               name="amenities[]" 
                               value="<?php echo $amenity['amenity_id']; ?>">
                        <label class="form-check-label" for="amenity_<?php echo $amenity['amenity_id']; ?>">
                          <?php echo htmlspecialchars($amenity['amenity_name']); ?>
                        </label>
                      </div>
                    </td>
                    <td><?php echo htmlspecialchars($amenity['description']); ?></td>
                    <td><?php echo htmlspecialchars($amenity['price_per_use'], 2); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            
            <!-- Quantity inputs for amenities that need them -->
            <div class="mt-3">
              <div class="row g-3">
                <?php if ($laundryAmenity): ?>
                  <div class="col-md-6" id="laundryQuantity" style="display: none;">
                    <label for="laundryKilos" class="form-label">Laundry Quantity (kg)</label>
                    <input type="number" class="form-control" id="laundryKilos" name="laundryKilos" min="1" max="10" value="1">
                  </div>
                <?php endif; ?>
                
                <?php if ($breakfastAmenity): ?>
                  <div class="col-md-6" id="breakfastQuantity" style="display: none;">
                    <label for="breakfastPersons" class="form-label">Breakfast Persons</label>
                    <input type="number" class="form-control" id="breakfastPersons" name="breakfastPersons" min="1" max="10" value="1">
                  </div>
                <?php endif; ?>
                
                <?php if ($gymAmenity): ?>
                  <div class="col-md-6" id="gymQuantity" style="display: none;">
                    <label for="gymPersons" class="form-label">Gym Persons</label>
                    <input type="number" class="form-control" id="gymPersons" name="gymPersons" min="1" max="10" value="1">
                  </div>
                <?php endif; ?>
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
      // Current selected room
      let currentRoom = null;
      let amenitiesTotal = 0;
      
      // Room type selection
      document.querySelectorAll('input[name="roomType"]').forEach(radio => {
        radio.addEventListener('change', function() {
          currentRoom = this.value;
          document.getElementById('roomIdField').value = this.dataset.roomId;
          document.getElementById('roomTypeNameField').value = this.value;
          
          // Also update the room number display
          document.getElementById('assignedRoomNumber').textContent = this.dataset.roomNumber;
          
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
        const selectedRadio = document.querySelector(`input[name="roomType"][value="${currentRoom}"]`);
        const maxGuests = selectedRadio.dataset.maxGuests;
        document.getElementById('pax').max = maxGuests;
        document.getElementById('pax').nextElementSibling.textContent = `Please enter number of guests (1-${maxGuests}).`;
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
          document.getElementById('roomPrice').textContent = '-';
          document.getElementById('totalPrice').textContent = '-';
          document.getElementById('finalPrice').textContent = '₱0.00';
          return;
        }
        
        const selectedRadio = document.querySelector(`input[name="roomType"][value="${currentRoom}"]`);
        const price = parseFloat(selectedRadio.dataset.price);
        
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        
        if (!checkIn || !checkOut) {
          // If dates aren't selected yet, default to 1 night
          document.getElementById('roomPrice').textContent = `₱${price.toFixed(2)}`;
          document.getElementById('totalPrice').textContent = `₱${price.toFixed(2)}`;
          updateFinalPrice();
          return;
        }
        
        const nights = calculateNights(checkIn, checkOut);
        const total = nights * price;
        
        document.getElementById('roomPrice').textContent = `₱${price.toFixed(2)}`;
        document.getElementById('totalPrice').textContent = `₱${total.toFixed(2)}`;
        updateFinalPrice();
        document.getElementById('selectedRoomType').textContent = 
          selectedRadio.value.charAt(0).toUpperCase() + selectedRadio.value.slice(1) + ' Room';
      }
      
      // Update final price including amenities
      function updateFinalPrice() {
        if (!currentRoom) {
          document.getElementById('finalPrice').textContent = '₱0.00';
          return;
        }
        
        const checkIn = document.getElementById('checkIn').value;
        const checkOut = document.getElementById('checkOut').value;
        let nights = 1;
        
        if (checkIn && checkOut) {
          nights = calculateNights(checkIn, checkOut);
        }
        
        const selectedRadio = document.querySelector(`input[name="roomType"][value="${currentRoom}"]`);
        const price = parseFloat(selectedRadio.dataset.price);
        const roomTotal = nights * price;
        const finalTotal = roomTotal + amenitiesTotal;
        
        document.getElementById('finalPrice').textContent = `${finalTotal.toLocaleString('en-PH')}.00`;
        document.getElementById('totalPriceField').value = finalTotal;
      }
      
  // Initialize payment method visibility on page load
document.addEventListener('DOMContentLoaded', function() {
  // Payment method initialization
  const gcashRadio = document.getElementById('gcash');
  const cardRadio = document.getElementById('card');
  
  if (gcashRadio?.checked) {
    document.getElementById('gcashPaymentField').style.display = 'block';
  } else if (cardRadio?.checked) {
    document.getElementById('cardPaymentFields').style.display = 'block';
  }
  
  // Payment method toggle
  gcashRadio?.addEventListener('change', function() {
    if (this.checked) {
      document.getElementById('gcashPaymentField').style.display = 'block';
      document.getElementById('cardPaymentFields').style.display = 'none';
      // Clear card fields
      document.getElementById('cardName').value = '';
      document.getElementById('cardNumber').value = '';
      document.getElementById('cardExpiry').value = '';
      document.getElementById('cardCvc').value = '';
    }
  });
  
  cardRadio?.addEventListener('change', function() {
    if (this.checked) {
      document.getElementById('cardPaymentFields').style.display = 'block';
      document.getElementById('gcashPaymentField').style.display = 'none';
      // Clear GCash fields
      document.getElementById('gcashName').value = '';
      document.getElementById('gcashNumber').value = '';
    }
  });
});
      
      // Date change handlers
      document.getElementById('checkIn').addEventListener('change', updatePrices);
      document.getElementById('checkOut').addEventListener('change', updatePrices);
      
      // Amenities handling
      document.querySelectorAll('input[name="amenities[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateAmenities);
      });
      
      // Special handling for quantity-based amenities
      <?php if ($laundryAmenity): ?>
        document.getElementById('amenity_<?php echo $laundryAmenity['Amenity_id']; ?>').addEventListener('change', function() {
          document.getElementById('laundryQuantity').style.display = this.checked ? 'block' : 'none';
          updateAmenities();
        });
      <?php endif; ?>
      
      <?php if ($breakfastAmenity): ?>
        document.getElementById('amenity_<?php echo $breakfastAmenity['Amenity_id']; ?>').addEventListener('change', function() {
          document.getElementById('breakfastQuantity').style.display = this.checked ? 'block' : 'none';
          updateAmenities();
        });
      <?php endif; ?>
      
      <?php if ($gymAmenity): ?>
        document.getElementById('amenity_<?php echo $gymAmenity['Amenity_id']; ?>').addEventListener('change', function() {
          document.getElementById('gymQuantity').style.display = this.checked ? 'block' : 'none';
          updateAmenities();
        });
      <?php endif; ?>
      
    // Update amenities when quantity inputs change
<?php if ($laundryAmenity): ?>
  document.getElementById('laundryKilos')?.addEventListener('input', updateAmenities);
<?php endif; ?>

<?php if ($breakfastAmenity): ?>
  document.getElementById('breakfastPersons')?.addEventListener('input', updateAmenities);
<?php endif; ?>

<?php if ($gymAmenity): ?>
  document.getElementById('gymPersons')?.addEventListener('input', updateAmenities);
<?php endif; ?>

function updateAmenities() {
  amenitiesTotal = 0;
  let amenitiesHtml = '';
  
  // Get all checked amenities
  const checkedAmenities = document.querySelectorAll('input[name="amenities[]"]:checked');
  
    checkedAmenities.forEach(checkbox => {
      const amenityId = checkbox.value;
      const amenityName = checkbox.nextElementSibling.textContent.trim();
      let price = 0;
      let quantity = 1;
      
      // Get price from data attribute (add data-price to your checkboxes)
      price = parseFloat(checkbox.dataset.price) || 0;
      
      // Handle quantity fields
      <?php if ($laundryAmenity): ?>
        if (amenityId === '<?php echo $laundryAmenity['amenity_id']; ?>') {
          quantity = parseInt(document.getElementById('laundryKilos')?.value) || 1;
        }
      <?php endif; ?>
      
      <?php if ($breakfastAmenity): ?>
        if (amenityId === '<?php echo $breakfastAmenity['amenity_id']; ?>') {
          quantity = parseInt(document.getElementById('breakfastPersons')?.value) || 1;
        }
      <?php endif; ?>
      
      <?php if ($gymAmenity): ?>
        if (amenityId === '<?php echo $gymAmenity['amenity_id']; ?>') {
          quantity = parseInt(document.getElementById('gymPersons')?.value) || 1;
        }
      <?php endif; ?>
      
      const total = price * quantity;
      amenitiesTotal += total;
      
      amenitiesHtml += `<div class="d-flex justify-content-between mb-2">
        <span>${amenityName}${quantity > 1 ? ` (${quantity})` : ''}:</span>
        <span>₱${total.toFixed(2)}</span>
      </div>`;
    });
    
    // Update amenities summary
    const amenitiesSummary = document.getElementById('amenitiesSummary');
    if (amenitiesHtml && amenitiesSummary) {
      document.getElementById('amenitiesList').innerHTML = amenitiesHtml;
      amenitiesSummary.style.display = 'block';
    } else if (amenitiesSummary) {
      amenitiesSummary.style.display = 'none';
    }
    
    updateFinalPrice();
}
      // Form validation
      const form = document.getElementById('reservationForm');
      form.addEventListener('submit', function(event) {
      });
            form.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
          this.classList.remove('is-invalid');
        });
      });
      
      updatePrices();
      
      // Handle room type from URL parameter
      const urlParams = new URLSearchParams(window.location.search);
      const roomParam = urlParams.get('room');
      if (roomParam) {
        const radio = document.querySelector(`input[name="roomType"][value="${roomParam}"]`);
        if (radio) {
          radio.checked = true;
          radio.dispatchEvent(new Event('change'));
          
          // Highlight the selected room card
          const selectedCard = document.getElementById(`${roomParam}RoomCard`);
          if (selectedCard) {
            selectedCard.classList.add('room-highlight');
            setTimeout(() => {
              selectedCard.classList.remove('room-highlight');
            }, 2000);
          }
        }
      }
      
      // Show success modal if reservation was successful
      <?php if (isset($success) && $success): ?>
        document.getElementById('confirmedRoomType').textContent = '<?php echo $reservationDetails['roomType']; ?>';
        document.getElementById('confirmedRoomNumber').textContent = '<?php echo $reservationDetails['roomNumber']; ?>';
        document.getElementById('confirmedPrice').textContent = '₱<?php echo number_format($reservationDetails['totalPrice'], 2); ?>';
        document.getElementById('confirmedCheckIn').textContent = '<?php echo $reservationDetails['checkIn']; ?>';
        document.getElementById('confirmedCheckOut').textContent = '<?php echo $reservationDetails['checkOut']; ?>';
        
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
      <?php endif; ?>
    });
  </script>
</body>
</html>
