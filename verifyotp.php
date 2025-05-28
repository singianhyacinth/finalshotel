<?php
require_once "dbaseconnection.php";

if (isset($_POST['sub'])) {
    $otpinput = $_POST['otp'];
    
    $otpsql = "SELECT * FROM tbl_customerdetails WHERE otp = '".$otpinput."'";
    $result = $conn->query($otpsql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        $updatesql = "UPDATE tbl_customerdetails SET status = 'Active', otp = NULL WHERE otp = '".$otpinput."'";
        if ($conn->query($updatesql)) {
            // Get user info for logging
            if (isset($user['user_id']) && isset($user['username'])) {
                $log_sql = "INSERT INTO tbl_logs (Action, Datetime, user_id) VALUES ('Account verified for ".$user['username']."', NOW(), ".$user['user_id'].")";
                $conn->query($log_sql);
            }
            
            // Redirect with success parameter
            header("Location: login.php?activation=success");
            exit();
        } else {
            echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error activating account",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Invalid OTP Number",
                showConfirmButton: false,
                timer: 1500
            });
        </script>';
    }
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification | The Bloom & Belle Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .height-100 {
            min-height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #102E53;
            border: none;
        }
        input:invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>

<form id="otpForm" action="verifyotp.php" method="post">
    <div class="container height-100 d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div class="card p-4 text-center">
                <h5 class="mb-4">Please enter the verification code sent to your email</h5>
                <div class="inputs d-flex justify-content-center mb-4">
                    <input class="form-control text-center" 
                           type="text" 
                           name="otp" 
                           id="otpInput"
                           maxlength="6" 
                           pattern="\d{6}"
                           style="font-size: 1.5rem; width: 200px;"
                           required
                           autofocus>
                </div>
                <div class="mt-3">
                    <button type="submit" name="sub" class="btn btn-primary px-4 py-2">Verify Account</button>
                </div>
                <div class="mt-3">
                    <a href="#" class="text-muted">Resend Code</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('otpInput').addEventListener('input', function(e) {
        // Only allow numeric input
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Visual feedback when 6 digits are entered
        if (this.value.length === 6) {
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });

    // Form validation before submission
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        const otpInput = document.getElementById('otpInput');
        if (otpInput.value.length !== 6) {
            e.preventDefault();
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Invalid OTP",
                text: "Please enter exactly 6 digits",
                showConfirmButton: false,
                timer: 1500
            });
            otpInput.focus();
        }
    });
</script>

</body>
</html>
