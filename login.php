<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="image/title_image.png" type="image/png">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <h1>Welcome Back</h1>
            <p class="subtitle">Login to your library account</p>

            <form id="loginForm" method="POST">

                <!-- Email -->
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email">
                    <small class="error" id="emailError"></small>
                </div>

                <!-- Password -->
                <div class="form-group password-group">
                    <label>Password</label>

                    <div class="password-wrapper">
                        <input type="password" id="password" maxlength="6" name="password">

                        <i class="fa-solid fa-eye eye-icon" id="togglePassword"></i>
                    </div>

                    <small class="error" id="passwordError"></small>
                </div>
                <!-- Remember & Forgot -->
                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" id="rememberMe">
                        Remember me
                    </label>

                    <a href="forgot_password.php" class="forgot">Forgot password?</a>
                </div>

                <button type="submit">Login</button>

                <p class="back-to-login">
                    Don’t have an account?
                    <a href="register.php">Create one</a>
                </p>

            </form>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>