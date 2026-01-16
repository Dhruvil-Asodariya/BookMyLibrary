const otpInput = document.getElementById("otp");
const otpError = document.getElementById("otpError");

const generatedOtp = Math.floor(1000 + Math.random() * 9000).toString();
alert("For demo, OTP is: " + generatedOtp);

function validateOtp() {
    const val = otpInput.value.trim();
    if (val === "") { otpError.textContent = "OTP is required"; return false; }
    else if (val !== generatedOtp) { otpError.textContent = "Invalid OTP"; return false; }
    else { otpError.textContent = ""; return true; }
}

otpInput.addEventListener("input", validateOtp);

document.getElementById("otpForm").addEventListener("submit", function (e) {
    e.preventDefault();
    if (validateOtp()) {
        alert("OTP verified successfully");
        window.location.href = "new_password.php";
    }
});
