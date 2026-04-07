function login() {
    // get the variables needed to login
    let username = $("#username").val();
    console.log(username);

    let password = $("#password").val();
    console.log(password);

    // checks if the variables aren't empty. if they are it alerts the user
    if (!username) return alert("Username required");
    if (!password) return alert("Password required");

    // ajax request to the server
    $.ajax({
        type: "POST",
        url: "inc/loginFunctions.php",
        data: {
            username: username,
            password: password,
        },
        success: function (response) {
            // checks what the response is before alerting the user and possibly redirecting to other page
            if (response == "Incorrect username or password.") {
                alert(response);
            } else {
                alert(response);
                window.location.href = "index.php";
            }
        },
        // error handling
        error: function (xhr, status, error) {
            console.log("ERROR:", error);
            console.log(xhr.responseText);
        },
    });
}

function signup() {
    // Regular expression for validating email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // get all the variables needed to sign up
    let username = $("#username").val();
    console.log(username);
    
    let email = $("#email").val();
    console.log(email);
    
    let password = $("#password").val();
    console.log(password);
    
    let cpassword = $("#cpassword").val();
    console.log(cpassword);
    
    // checks if the variables aren't empty. if they are it alerts the user
    if (!username) return alert("Username required");
    if (!email) return alert("Email required");
    if (!emailRegex.test(email)) return alert("Invalid email format");
    if (!password) return alert("Password required");
    if (!cpassword) return alert("Confirm your password");
    if (password !== cpassword) return alert("Passwords don't match");

    // ajax request to the server
    $.ajax({
        type: "POST",
        url: "inc/signupFunctions.php",
        data: {
            username: username,
            email: email,
            password: password,
        },
        success: function (response) {
            // checks what the response is before alerting the user and possibly redirecting to other page
            if (
                response == "Username is already taken." ||
                response == "Email is already taken."
            ) {
                alert(response);
            } else {
                alert(response);
                window.location.href = "login.php";
            }
        },
        // error handling
        error: function (xhr, status, error) {
            console.log("ERROR:", error);
            console.log(xhr.responseText);
        },
    });
}

$(document).ready(function () {
    // sign up button click event listener
    $(document).on("click", "#signup-btn", function () {
        signup();
    });

    // log in button click event listener
    $(document).on("click", "#login-btn", function () {
        login();
    });
});
