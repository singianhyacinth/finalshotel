<?php
require_once "dbaseconnection.php"; 

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['sub'])) {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $guestName = $_POST['guestName'];
    $pax = $_POST['pax'];
    $specialRequest = $_POST['specialRequest'];
    $paymentMode = $_POST['paymentMode'];
    $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];
    $policyCheck = $_POST['policyCheck'];
    $termsCheck = $_POST['termsCheck'];

    $reservation_status = "Confirmed";
    
    // calculate nights
    $checkInDate = new DateTime($checkIn);
    $checkOutDate = new DateTime($checkOut);
    $nights = $checkOutDate->diff($checkInDate)->days;

    // get room price
    $roomSql = "SELECT * FROM tbl_room WHERE room_id = '$room_id'";
    $roomResult = $conn->query($roomSql);

    if ($roomResult->num_rows > 0) {
        $room = $roomResult->fetch_assoc();
        $roomPrice = $room['price_per_use'] * $nights;
     
    } else {
        echo "Room not found";
        exit;
    }

    // amenities handling
    $amenitiesArray = [];
    $amenitiesTotal = 0;

    foreach ($amenities as $amenity_id) {
        $amenitySql = "SELECT * FROM tbl_amenity WHERE amenity_id = '$amenity_id'";
        $amenityResult = $conn->query($amenitySql);
        if ($amenityResult->num_rows > 0) {
            $amenity = $amenityResult->fetch_assoc();
            $quantity = 1;

            if (isset($_POST['laundryKilos']) && $amenity_id == $_POST['laundry_amenity_id']) {
                $quantity = intval($_POST['laundryKilos']);
            } elseif (isset($_POST['breakfastPersons']) && $amenity_id == $_POST['breakfast_amenity_id']) {
                $quantity = intval($_POST['breakfastPersons']);
            } elseif (isset($_POST['gymPersons']) && $amenity_id == $_POST['gym_amenity_id']) {
                $quantity = intval($_POST['gymPersons']);
            }

            $totalAmenityPrice = $quantity * $amenity['price_per_use'];
            $amenitiesTotal += $totalAmenityPrice;

            $amenitiesArray[] = [
                'id' => $amenity_id,
                'name' => $amenity['amenity_name'],
                'quantity' => $quantity,
                'price' => $amenity['price_per_use']
            ];
        }
    }

    $totalPrice = $roomPrice + $amenitiesTotal;
    $amenitiesJson = json_encode($amenitiesArray);

    // insert reservation
    $insertSql = "INSERT INTO tbl_reservation (user_id, room_id, check_in_date, check_out_date, total_price, reservation_status) 
                VALUES ('$user_id', '$room_id', '$checkIn', '$checkOut', '$totalPrice', '$reservation_status')";

    if ($conn->query($insertSql) === TRUE) {
        $reservationId = $conn->insert_id;

        // update room availability
        $updateSql = "UPDATE tbl_room SET availability_status = '0' WHERE room_id = '$room_id'";
        $conn->query($updateSql);
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Reservation Successful!",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = "dashboard.php?id=<?php echo $reservationId; ?>";
            });
        </script>
        <?php
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
</script>
<?php

// helper functions
function calculateNights($checkIn, $checkOut) {
    $start = new DateTime($checkIn);
    $end = new DateTime($checkOut);
    return $end->diff($start)->days;
}

function getRooms($conn) {
  // get one available room for each type
  $sql = "SELECT r.* FROM tbl_room r
          INNER JOIN (
              SELECT room_type, MIN(room_id) as min_id
              FROM tbl_room
              WHERE availability_status = '1'
              GROUP BY room_type
          ) t ON r.room_id = t.min_id";
  
  $result = $conn->query($sql);
  $rooms = [];
  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $rooms[] = $row;
      }
  }
  return $rooms;
}

function getAmenities($conn) {
    $sql = "SELECT * FROM tbl_amenity";
    $result = $conn->query($sql);
    $amenities = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $amenities[] = $row;
        }
    }
    return $amenities;
}

function getRoomById($conn, $id) {
    $sql = "SELECT * FROM tbl_room WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getAmenityById($conn, $id) {
    $sql = "SELECT * FROM tbl_amenity WHERE amenity_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// fetch data
$rooms = getRooms($conn);
$amenities = getAmenities($conn);

// identify specific amenities
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
      <input type="hidden" name="room_id" id="roomIdField">
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

<!-- Room Type Selection -->
<div class="mb-4">
    <?php 
    // Group rooms by type to ensure we only show one per type
    $groupedRooms = [];
    foreach ($rooms as $room) {
        $groupedRooms[strtolower($room['room_type'])] = $room;
    }
    
    // Define the order we want to display room types
    $roomTypesOrder = ['classic', 'premier', 'deluxe'];
    
    foreach ($roomTypesOrder as $type): 
        if (isset($groupedRooms[$type])): 
            $room = $groupedRooms[$type];
    ?>
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
                        <h5><?php echo htmlspecialchars(ucfirst($room['room_type'])); ?> Room</h5>
                        <p class="mb-1"><?php echo htmlspecialchars($room['description']); ?></p>
                        <small>Room #<?php echo htmlspecialchars($room['room_number']); ?></small>
                    </div>
                    <div class="price-container">
                        <span class="fw-bold">₱<?php echo htmlspecialchars($room['price_per_use'], 2); ?></span>
                        <span class="room-availability">Available</span>
                    </div>
                </div>
            </label>
        </div>
    <?php 
        endif;
    endforeach; 
    ?>
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
                    </td>

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
                <?php if ($laundryAmenity): ?>
                <input type="hidden" name="laundry_amenity_id" value="<?php echo $laundryAmenity['amenity_id']; ?>">
              <?php endif; ?>
              <?php if ($breakfastAmenity): ?>
                <input type="hidden" name="breakfast_amenity_id" value="<?php echo $breakfastAmenity['amenity_id']; ?>">
              <?php endif; ?>
              <?php if ($gymAmenity): ?>
                <input type="hidden" name="gym_amenity_id" value="<?php echo $gymAmenity['amenity_id']; ?>">
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
    <div class="mb-2">
        <small>Check-in:</small>
        <div id="summaryCheckIn" class="fw-bold">-</div>
    </div>
    <div class="mb-2">
        <small>Check-out:</small>
        <div id="summaryCheckOut" class="fw-bold">-</div>
    </div>
    <div class="mb-2">
        <small>Night/s:</small>
        <div id="summaryNights" class="fw-bold">-</div>
    </div>
    <div class="mb-2 d-flex justify-content-between">
        <span>Price per night:</span>
        <span id="roomPrice">-</span>
    </div>
    <div class="mb-3 d-flex justify-content-between">
        <span>Total Room Price:</span>
        <span id="totalRoomPrice">-</span>
    </div>

    <!-- Amenities Summary -->
    <div id="amenitiesSummary" class="mb-3" style="display: none;">
        <h5 class="fw-bold mt-4">Additional Amenities</h5>
        <div id="amenitiesList"></div>
        <div class="d-flex justify-content-between mt-2">
            <span>Total Amenities:</span>
            <span id="totalAmenitiesPrice">₱0.00</span>
        </div>
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
      <div class="mt-4">
        <button type="submit" class="reserve-btn" name ="sub">Reserve</button>
        
      </div>
      
    </form>
    
  </div>
<!-- real-time calculations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // get elements
    const roomRadios = document.querySelectorAll('input[name="roomType"]');
    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');
    const paxInput = document.getElementById('pax');
    const amenitiesCheckboxes = document.querySelectorAll('input[name="amenities[]"]');
    const laundryQuantity = document.getElementById('laundryKilos');
    const breakfastQuantity = document.getElementById('breakfastPersons');
    const gymQuantity = document.getElementById('gymPersons');
    
    // summary elements
    const selectedRoomTypeEl = document.getElementById('selectedRoomType');
    const assignedRoomNumberEl = document.getElementById('assignedRoomNumber');
    const summaryCheckInEl = document.getElementById('summaryCheckIn');
    const summaryCheckOutEl = document.getElementById('summaryCheckOut');
    const summaryNightsEl = document.getElementById('summaryNights');
    const roomPriceEl = document.getElementById('roomPrice');
    const totalRoomPriceEl = document.getElementById('totalRoomPrice');
    const amenitiesListEl = document.getElementById('amenitiesList');
    const totalAmenitiesPriceEl = document.getElementById('totalAmenitiesPrice');
    const finalPriceEl = document.getElementById('finalPrice');
    const amenitiesSummaryEl = document.getElementById('amenitiesSummary');
    
    // hidden fields
    const roomIdField = document.getElementById('roomIdField');
    const totalPriceField = document.getElementById('totalPriceField');
    
    // current selection
    let selectedRoom = null;
    let selectedAmenities = [];
    
    //  event listeners
    roomRadios.forEach(radio => {
        radio.addEventListener('change', updateRoomSelection);
    });
    
    checkInInput.addEventListener('change', updateBookingSummary);
    checkOutInput.addEventListener('change', updateBookingSummary);
    paxInput.addEventListener('change', updateBookingSummary);
    
    amenitiesCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateAmenitiesSelection);
    });
    
    if (laundryQuantity) laundryQuantity.addEventListener('input', updateBookingSummary);
    if (breakfastQuantity) breakfastQuantity.addEventListener('input', updateBookingSummary);
    if (gymQuantity) gymQuantity.addEventListener('input', updateBookingSummary);
    
    //  room selection
    function updateRoomSelection() {
        const selectedRadio = document.querySelector('input[name="roomType"]:checked');
        if (!selectedRadio) return;
        
        selectedRoom = {
            id: selectedRadio.dataset.roomId,
            type: selectedRadio.value,
            number: selectedRadio.dataset.roomNumber,
            price: parseFloat(selectedRadio.dataset.price),
            maxGuests: parseInt(selectedRadio.dataset.maxGuests)
        };
        
        // update UI
        selectedRoomTypeEl.textContent = selectedRadio.value.charAt(0).toUpperCase() + selectedRadio.value.slice(1) + ' Room';
        assignedRoomNumberEl.textContent = selectedRoom.number;
        roomPriceEl.textContent = '₱' + selectedRoom.price.toFixed(2);
        
        // update hidden field
        roomIdField.value = selectedRoom.id;
        
        // update booking summary
        updateBookingSummary();
    }
    
    // update amenities selection
    function updateAmenitiesSelection() {
        selectedAmenities = [];
        
        amenitiesCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const amenityId = checkbox.value;
                const amenityRow = checkbox.closest('tr');
                const amenityName = amenityRow.querySelector('td:nth-child(2) label').textContent.trim();
                const amenityPrice = parseFloat(amenityRow.querySelector('td:nth-child(4)').textContent);
                
                // Check if this amenity has a quantity input
                let quantity = 1;
                if (checkbox.id === 'amenity_' + '<?php echo $laundryAmenity ? $laundryAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('laundryQuantity').style.display = 'block';
                    quantity = parseInt(laundryQuantity.value) || 1;
                } else if (checkbox.id === 'amenity_' + '<?php echo $breakfastAmenity ? $breakfastAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('breakfastQuantity').style.display = 'block';
                    quantity = parseInt(breakfastQuantity.value) || 1;
                } else if (checkbox.id === 'amenity_' + '<?php echo $gymAmenity ? $gymAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('gymQuantity').style.display = 'block';
                    quantity = parseInt(gymQuantity.value) || 1;
                }
                
                selectedAmenities.push({
                    id: amenityId,
                    name: amenityName,
                    price: amenityPrice,
                    quantity: quantity,
                    total: amenityPrice * quantity
                });
            } else {
                // Hide quantity inputs if not selected
                if (checkbox.id === 'amenity_' + '<?php echo $laundryAmenity ? $laundryAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('laundryQuantity').style.display = 'none';
                } else if (checkbox.id === 'amenity_' + '<?php echo $breakfastAmenity ? $breakfastAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('breakfastQuantity').style.display = 'none';
                } else if (checkbox.id === 'amenity_' + '<?php echo $gymAmenity ? $gymAmenity["amenity_id"] : ""; ?>') {
                    document.getElementById('gymQuantity').style.display = 'none';
                }
            }
        });
        
        updateBookingSummary();
    }
    
    // Update booking summary
    function updateBookingSummary() {
        // Update dates display
        if (checkInInput.value) {
            summaryCheckInEl.textContent = formatDate(checkInInput.value);
        }
        if (checkOutInput.value) {
            summaryCheckOutEl.textContent = formatDate(checkOutInput.value);
        }
        
        // Calculate nights
        let nights = 0;
        if (checkInInput.value && checkOutInput.value) {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);
            nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
            summaryNightsEl.textContent = nights;
        }
        
        // Update room price if room is selected
        if (selectedRoom) {
            const totalRoomPrice = selectedRoom.price * nights;
            totalRoomPriceEl.textContent = '₱' + totalRoomPrice.toFixed(2);
        }
        
        // Update amenities list and total
        updateAmenitiesList();
        
        // Calculate final price
        const roomPrice = selectedRoom ? selectedRoom.price * nights : 0;
        const amenitiesTotal = selectedAmenities.reduce((sum, amenity) => sum + amenity.total, 0);
        const finalPrice = roomPrice + amenitiesTotal;
        
        finalPriceEl.textContent = '₱' + finalPrice.toFixed(2);
        totalPriceField.value = finalPrice.toFixed(2);
    }
    
    // Update amenities list
    function updateAmenitiesList() {
        if (selectedAmenities.length === 0) {
            amenitiesSummaryEl.style.display = 'none';
            return;
        }
        
        amenitiesSummaryEl.style.display = 'block';
        amenitiesListEl.innerHTML = '';
        
        // Update quantities for amenities that have them
        selectedAmenities.forEach(amenity => {
            if (amenity.id === '<?php echo $laundryAmenity ? $laundryAmenity["amenity_id"] : ""; ?>' && laundryQuantity) {
                amenity.quantity = parseInt(laundryQuantity.value) || 1;
                amenity.total = amenity.price * amenity.quantity;
            } else if (amenity.id === '<?php echo $breakfastAmenity ? $breakfastAmenity["amenity_id"] : ""; ?>' && breakfastQuantity) {
                amenity.quantity = parseInt(breakfastQuantity.value) || 1;
                amenity.total = amenity.price * amenity.quantity;
            } else if (amenity.id === '<?php echo $gymAmenity ? $gymAmenity["amenity_id"] : ""; ?>' && gymQuantity) {
                amenity.quantity = parseInt(gymQuantity.value) || 1;
                amenity.total = amenity.price * amenity.quantity;
            }
        });
        
        // Create list items for each amenity
        selectedAmenities.forEach(amenity => {
            const amenityItem = document.createElement('div');
            amenityItem.className = 'd-flex justify-content-between';
            amenityItem.innerHTML = `
                <span>${amenity.name} (${amenity.quantity})</span>
                <span>₱${(amenity.total).toFixed(2)}</span>
            `;
            amenitiesListEl.appendChild(amenityItem);
        });
        
        // Update amenities total
        const amenitiesTotal = selectedAmenities.reduce((sum, amenity) => sum + amenity.total, 0);
        totalAmenitiesPriceEl.textContent = '₱' + amenitiesTotal.toFixed(2);
    }
    
    // Helper function to format date
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }
    
    // Initialize form validation
    const form = document.getElementById('reservationForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
    
    // Payment method toggle
    document.querySelectorAll('input[name="paymentMode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('gcashPaymentField').style.display = 
                this.id === 'gcash' ? 'block' : 'none';
            document.getElementById('cardPaymentFields').style.display = 
                this.id === 'card' ? 'block' : 'none';
        });
    });
});
</script>

</body>
</html>
