<?php

header('Content-Type: application/json');

// Database connection
require_once "dbaseconnection.php";

// // Define required fields
// $requiredFields = [
//     'user_id' => 'User ID',
//     'accommodation_id' => 'Accommodation ID',
//     'room_id' => 'Room ID',
//     'checkIn' => 'Check-in date',
//     'checkOut' => 'Check-out date'
// ];

// Get all form data with proper null checks
$user_id = $_POST['user_id'] ?? null;
$accommodation_id = $_POST['accommodation_id'] ?? null;
$room_id = $_POST['room_id'] ?? null;
$check_in = $_POST['checkIn'] ?? '';
$check_out = $_POST['checkOut'] ?? '';
$total_price = $_POST['totalPrice'] ?? 0;
$reservation_status = 'Confirmed'; // Default status

// Amenities data (assuming it comes as JSON string or array)
$amenities = json_decode($_POST['amenities'] ?? '[]', true);

// Validate required fields
$missingFields = [];
foreach ($requiredFields as $field => $name) {
    if (empty($_POST[$field] ?? null)) {
        $missingFields[] = $name;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields: ' . implode(', ', $missingFields),
        'received_data' => $_POST
    ]);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    // Insert into reservation table
    $sql = "INSERT INTO tbl_reservation (
        user_id,
        accomodation_id, 
        room_id,
        check_in_date, 
        check_out_date, 
        total_price, 
        reservation_status
    ) VALUES (
        '{$_POST['user_id']}', 
        '{$_POST['accommodation_id']}', 
        '{$_POST['room_id']}',
        '{$_POST['checkIn']}', 
        '{$_POST['checkOut']}', 
        {$_POST['totalPrice']}, 
        '{$reservation_status}'
    )";

    // Process amenities if provided
    if (!empty($amenities)) {
        // Prepare the statement for inserting amenities
        $amenitySql = "INSERT INTO tbl_amenity (amenity_id, amenity_name, description, price_per_use) 
        VALUES (?, ?, ?,?)";
        
        $amenityStmt = $conn->prepare($amenitySql);
        
        foreach ($amenities as $amenity) {
            $amenityName = '';
            $description = '';
            $price = 0;
            
            switch ($amenity['type']) {
                case 'extraBed':
                    $amenityName = 'Extra Bed';
                    $description = 'Additional bed for extra guest';
                    $price = 800;
                    break;
                    
                case 'massage':
                    $amenityName = 'Massage';
                    $description = 'Professional massage service';
                    $price = 1000;
                    break;
                    
                case 'laundry':
                    $amenityName = 'Laundry Service';
                    $description = 'Laundry service per kilogram';
                    $price = 200;
                    break;
                    
                case 'breakfast':
                    $amenityName = 'Breakfast Buffet';
                    $description = 'Breakfast buffet per person';
                    $price = 600;
                    break;
                    
                case 'gym':
                    $amenityName = 'Gym Access';
                    $description = 'Gym access per person';
                    $price = 300;
                    break;
            }
            
            if (!empty($amenityName)) {
                $amenityStmt->bind_param(
                    "ssi", 
                    $amenityName, 
                    $description, 
                    $price
                );
                if (!$amenityStmt->execute()) {
                    throw new Exception("Failed to insert amenity: " . $amenityStmt->error);
                }
            }
        }
        
        $amenityStmt->close();
    }

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode([
        'status' => 'success', 
        'reservation_id' => $reservation_id,
        'message' => 'Reservation created successfully with amenities'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    // Return error response
    echo json_encode([
        'status' => 'error', 
        'message' => 'Reservation failed: ' . $e->getMessage()
    ]);
}

// Close connection
$conn->close();
