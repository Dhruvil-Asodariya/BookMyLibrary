<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="image/title_image.png" type="image/png">
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Forgot Password</h1>


            <form id="forgotForm" novalidate>
                <p class="subtitle">Enter your registered email to receive OTP</p>
                <!-- Email -->
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email">
                    <small class="error" id="emailError"></small>
                </div>

                <button type="submit" id="sendOtpBtn">Send OTP</button>
            </form>

            <!-- OTP Section (hidden initially) -->
            <form id="otpForm" style="display:none;" novalidate>
                <p class="subtitle">Enter OTP received to registered email</p>
                <div class="form-group">
                    <label>Enter OTP</label>
                    <input type="text" id="otp" maxlength="6">
                    <small class="error" id="otpError"></small>
                </div>

                <button type="submit" id="verifyOtpBtn">Verify OTP</button>
            </form>

            <!-- Reset Password Section (hidden initially) -->
            <form id="resetForm" style="display:none;" novalidate>
                <p class="subtitle">Enter new credentials</p>
                <!-- New Password -->
                <div class="form-group password-group">
                    <label>New Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="newPassword" maxlength="6" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        <i class="fa-solid fa-eye eye-icon" id="toggleNewPassword"></i>
                    </div>
                    <small class="error" id="newPasswordError"></small>
                </div>

                <!-- Confirm Password -->
                <div class="form-group password-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" maxlength="6" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        <i class="fa-solid fa-eye eye-icon" id="toggleConfirmPassword"></i>
                    </div>
                    <small class="error" id="confirmPasswordError"></small>
                </div>

                <button type="submit">Reset Password</button>
            </form>


            <p class="back-to-login">
                <a href="login.php"><i class="fa-solid fa-arrow-left"></i> Back to Login</a>
            </p>
        </div>
    </div>

    <script src="js/forgot.js"></script>
</body>

</html>