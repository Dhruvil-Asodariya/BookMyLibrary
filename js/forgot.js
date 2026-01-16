// Elements
const email = document.getElementById("email");
const emailError = document.getElementById("emailError");

const forgotForm = document.getElementById("forgotForm");
const otpForm = document.getElementById("otpForm");
const resetForm = document.getElementById("resetForm");

const otpInput = document.getElementById("otp");
const otpError = document.getElementById("otpError");

const newPassword = document.getElementById("newPassword");
const newPasswordError = document.getElementById("newPasswordError");
const confirmPassword = document.getElementById("confirmPassword");
const confirmPasswordError = document.getElementById("confirmPasswordError");
const toggleNewPassword = document.getElementById("toggleNewPassword");
const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

let generatedOtp = "";

// Email Validation
function validateEmail() {
    const value = email.value.trim();
    const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
    if (value === "") {
        emailError.textContent = "Email is required";
        return false;
    } else if (!pattern.test(value)) {
        emailError.textContent = "Enter a valid email";
        return false;
    } else {
        emailError.textContent = "";
        return true;
    }
}
email.addEventListener("input", validateEmail);

// Send OTP
forgotForm.addEventListener("submit", function(e){
    e.preventDefault();
    if(validateEmail()){
        generatedOtp = Math.floor(100000 + Math.random()*900000).toString(); // 6-digit OTP
        alert(`Your OTP is: ${generatedOtp}`); // For demo; in real app, send via email/SMS
        forgotForm.style.display = "none";
        otpForm.style.display = "block";
    }
});

// OTP Validation
function validateOtp() {
    const value = otpInput.value.trim();
    if(value === ""){
        otpError.textContent = "OTP is required";
        return false;
    } else if(value !== generatedOtp){
        otpError.textContent = "Invalid OTP";
        return false;
    } else {
        otpError.textContent = "";
        return true;
    }
}

otpInput.addEventListener("input", validateOtp);

otpForm.addEventListener("submit", function(e){
    e.preventDefault();
    if(validateOtp()){
        otpForm.style.display = "none";
        resetForm.style.display = "block";
    }
});

// Password Validation (6 digits only)
function validateNewPassword(){
    const value = newPassword.value.trim();
    const digitPattern = /^[0-9]{6}$/;
    if(value === ""){
        newPasswordError.textContent = "Password is required";
        return false;
    } else if(!digitPattern.test(value)){
        newPasswordError.textContent = "Password must be exactly 6 digits";
        return false;
    } else {
        newPasswordError.textContent = "";
        return true;
    }
}
newPassword.addEventListener("input", validateNewPassword);

// Show/hide password
toggleNewPassword.addEventListener("click", ()=>{
    if(newPassword.type === "password"){
        newPassword.type = "text";
        toggleNewPassword.classList.replace("fa-eye","fa-eye-slash");
    } else {
        newPassword.type = "password";
        toggleNewPassword.classList.replace("fa-eye-slash","fa-eye");
    }
});

// Confirm Password Validation
function validateConfirmPassword(){
    const value = confirmPassword.value.trim();
    if(value === ""){
        confirmPasswordError.textContent = "Confirm Password is required";
        return false;
    } else if(value !== newPassword.value){
        confirmPasswordError.textContent = "Passwords do not match";
        return false;
    } else {
        confirmPasswordError.textContent = "";
        return true;
    }
}
confirmPassword.addEventListener("input", validateConfirmPassword);

// Show/hide confirm password
toggleConfirmPassword.addEventListener("click", ()=>{
    if(confirmPassword.type === "password"){
        confirmPassword.type = "text";
        toggleConfirmPassword.classList.replace("fa-eye","fa-eye-slash");
    } else{
        confirmPassword.type = "password";
        toggleConfirmPassword.classList.replace("fa-eye-slash","fa-eye");
    }
});

// Reset Password Submission
resetForm.addEventListener("submit", function(e){
    e.preventDefault();
    const validNew = validateNewPassword();
    const validConfirm = validateConfirmPassword();
    if(validNew && validConfirm){
        alert("Password reset successful!");
        window.location.href = "login.php";
    }
});