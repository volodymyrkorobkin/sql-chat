
//Validate the form
function validateSignUp() {
    console.log("Validating sign up form");
    var password = document.forms["sign_up_form"]["password"].value;
    var password_confirm = document.forms["sign_up_form"]["password_confirm"].value;

    if (password != password_confirm) {
        alert("Passwords do not match");
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('sign_up_form').addEventListener('submit', async function(event) {
        if (!validateSignUp()) {
            event.preventDefault();
        }
    });
});
