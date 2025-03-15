<?php
include 'config.php';
session_start();

// Check if user is already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: admin_page.php');
    exit;
}
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

if (isset($_POST['submit'])) {
    // Sanitize email input
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Email validation to check for a valid domain provider (like gmail.com, yahoo.com, etc.)
    $valid_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'aol.com'];
    $email_parts = explode('@', $email);

    if (count($email_parts) != 2 || !in_array(strtolower($email_parts[1]), $valid_domains)) {
        $message[] = 'Please enter a valid email address with a recognized domain (e.g., gmail.com, yahoo.com, etc.).';
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message[] = 'Invalid email format!';
        } else {
            // Sanitize password input and hash it using md5
            $password = md5($_POST['password']);

            // Query to select user based on email
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

            if (mysqli_num_rows($select_users) > 0) {
                $row = mysqli_fetch_assoc($select_users);

                // Check if the password matches using md5
                if ($row['password'] == $password) {
                    // Store user information in session
                    if ($row['user_type'] == 'admin') {
                        $_SESSION['admin_name'] = $row['name'];
                        $_SESSION['admin_email'] = $row['email'];
                        $_SESSION['admin_id'] = $row['id'];
                        header('Location: admin_page.php');
                        exit;
                    } elseif ($row['user_type'] == 'user') {
                        $_SESSION['user_name'] = $row['name'];
                        $_SESSION['user_email'] = $row['email'];
                        $_SESSION['user_id'] = $row['id'];
                        header('Location: home.php');
                        exit;
                    }
                } else {
                    $message[] = 'Incorrect email or password!';
                }
            } else {
                $message[] = 'User not found!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<div class="form-container">
    <form action="" method="post" onsubmit="return validateForm()">
        <h3>Login Now</h3>
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="submit" name="submit" value="Login Now" class="btn">
        <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>

    <script>
    function validateForm() {
        const emailInput = document.querySelector('input[name="email"]');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(emailInput.value)) {
            alert('Please enter a valid email address.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
    </script>
</div>

</body>

</html>
