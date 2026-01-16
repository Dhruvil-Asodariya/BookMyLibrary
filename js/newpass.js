const newPassword = document.getElementById("newPassword");
const newPasswordError = document.getElementById("newPasswordError");
const toggleNewPassword = document.getElementById("toggleNewPassword");

// Show/hide password
toggleNewPassword.addEventListener("click", ()=>{
    if(newPassword.type === "password"){
        newPassword.type="text";
        toggleNewPassword.classList.replace("fa-eye","fa-eye-slash");
    } else {
        newPassword.type="password";
        toggleNewPassword.classList.replace("fa-eye-slash","fa-eye");
    }
});

// Validate 6-digit password
function validateNewPassword(){
    const val = newPassword.value.trim();
    const pattern = /^[0-9]{6}$/;
    if(val===""){ newPasswordError.textContent="Password is required"; return false;}
    else if(!pattern.test(val)){ newPasswordError.textContent="Password must be exactly 6 digits"; return false;}
    else { newPasswordError.textContent=""; return true;}
}

newPassword.addEventListener("input", validateNewPassword);

// Submit
document.getElementById("newPassForm").addEventListener("submit", function(e){
    e.preventDefault();
    if(validateNewPassword()){
        alert("Password reset successful!");
        window.location.href="login.php";
    }
});
