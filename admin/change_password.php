<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password | Library System</title>
    <link rel="icon" href="../image/title_image.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="image/title_image.png" type="image/png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "JetBrains Mono", "Fira Code", Consolas, monospace;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            padding: 20px;
        }

        .login-card {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 25px 40px rgba(0, 0, 0, 0.25);
            position: relative;
        }

        .login-card h1 {
            text-align: center;
            color: #0f172a;
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 15px;
            font-size: 22px;
            font-weight: bold;
            color: #555;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: #000;
            transform: scale(1.2);
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 30px;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 15px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;
        }

        /* Error Message */
        .error {
            color: #e63946;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Input Error Border */
        .form-group input.error-input {
            border: 2px solid #e63946;
            background: #fff5f5;
        }



        /* Button */
        button {
            width: 100%;
            padding: 13px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #1e40af;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .eye-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #64748b;
        }

        .eye-icon:hover {
            color: #2563eb;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #334155;
        }

        .forgot {
            color: #2563eb;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .back-to-login {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .back-to-login a {
            color: #2563eb;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        /* Optional: spacing for the submit button */
        form button {
            margin-top: 20px;
        }


        /* Mobile */
        @media (max-width: 480px) {
            .login-card {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <span class="close-btn" onclick="goBack()">×</span>
            <p class="subtitle">Change Password to your library account</p>

            <form id="loginForm" method="POST">

                <!-- Password -->
                <div class="form-group password-group">
                    <label>Password</label>

                    <div class="password-wrapper">
                        <input type="password" id="password" maxlength="6" name="password">

                        <i class="fa-solid fa-eye eye-icon" id="togglePassword"></i>
                    </div>

                    <small class="error" id="passwordError"></small>
                </div>

                <!-- Confirm Password -->
                <div class="form-group password-group">
                    <label>Confirm Password</label>

                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" maxlength="6" name="confirmPassword">

                        <i class="fa-solid fa-eye eye-icon" id="toggleConfirmPassword"></i>
                    </div>

                    <small class="error" id="confirmPasswordError"></small>
                </div>


                <button type="submit">Change Password</button>



            </form>
        </div>
    </div>

</body>

<script>
    const password = document.getElementById("password");
    const confirmpassword = document.getElementById("confirmPassword");

    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    const togglePassword = document.getElementById("togglePassword");
    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

    /* Password Validation */
    function validatePassword() {
        const value = password.value.trim();
        const digitPattern = /^[0-9]{6}$/;

        if (value === "") {
            passwordError.textContent = "Password is required";
            password.classList.add("error-input");
            return false;
        } else if (!digitPattern.test(value)) {
            passwordError.textContent = "Password must be exactly 6 digits";
            password.classList.add("error-input");
            return false;
        } else {
            passwordError.textContent = "";
            password.classList.remove("error-input");
            return true;
        }
    }

    /* Confirm Password Validation */
    function validateConfirmPassword() {
        const value = confirmpassword.value.trim();
        const digitPattern = /^[0-9]{6}$/;

        if (value === "") {
            confirmPasswordError.textContent = "Confirm Password is required";
            confirmpassword.classList.add("error-input");
            return false;
        } else if (value !== password.value.trim()) {
            confirmPasswordError.textContent = "Confirm Passwords do not match";
            confirmpassword.classList.add("error-input");
            return false;
        } else {
            confirmPasswordError.textContent = "";
            confirmpassword.classList.remove("error-input");
            return true;
        }
    }


    /* Live validation */
    password.addEventListener("input", validatePassword);
    confirmpassword.addEventListener("input", validateConfirmPassword);

    /* Show / Hide password */
    togglePassword.addEventListener("click", () => {
        if (password.type === "password") {
            password.type = "text";
            togglePassword.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            password.type = "password";
            togglePassword.classList.replace("fa-eye-slash", "fa-eye");
        }
    });

    toggleConfirmPassword.addEventListener("click", () => {
        if (confirmpassword.type === "password") {
            confirmpassword.type = "text";
            toggleConfirmPassword.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            confirmpassword.type = "password";
            toggleConfirmPassword.classList.replace("fa-eye-slash", "fa-eye");
        }
    });

    /* Submit Validation (SHOW ALL ERRORS) */
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();

        if (isPasswordValid && isConfirmPasswordValid) {

            alert("Password Changed Successfully");
            window.location.href = "home.php";

        }
    });

    function goBack() {
        window.history.back();
    }
</script>

</html>