function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var togglePasswordBtn = document.getElementById("toggle-password");
    
    if (passwordField && togglePasswordBtn) {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePasswordBtn.classList.add("hide-password");
        } else {
            passwordField.type = "password";
            togglePasswordBtn.classList.remove("hide-password");
        }
    }
}
