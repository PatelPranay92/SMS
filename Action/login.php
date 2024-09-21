<?php
// Check if the login form has been submitted
if (isset($_POST['login'])) {
    // Retrieve the email and password from the POST request
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    // Check if the provided email and password match the hardcoded admin credentials
    if ($email == 'admin@gmail.com' && $pass == 'admin123') {
        // Start a new session
        session_start();
        // Set a session variable to indicate the user is logged in
        $_SESSION['login'] = true;
        // Redirect to the homepage
        header('Location:../Admin/dashboard.php');
        exit; // Terminate the script to ensure the redirect happens immediately
    } else {
        // Display an error message if the credentials are incorrect
        echo "Invalid Email or Password";
    }
}
?>
