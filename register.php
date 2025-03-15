<?php
include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); // Using md5 for simplicity as per the original requirement
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   // Check if password and confirm password are the same
   if ($pass !== $cpass) {
      $message[] = 'Passwords do not match!';
   } else {
      // Email validation - Regular expression for valid email providers
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $message[] = 'Invalid email format!';
      } else {
         // Check for common misspellings in domain names
         $valid_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'aol.com'];
         $email_parts = explode('@', $email);

         // If there's no domain part or the domain part is invalid, show an error
         if (count($email_parts) != 2 || !in_array(strtolower($email_parts[1]), $valid_domains)) {
            $message[] = 'Please enter a valid email address with a recognized domain (e.g., gmail.com, yahoo.com, etc.).';
         } else {
            // Check if user already exists with the same email
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

            if(mysqli_num_rows($select_users) > 0){
               $message[] = 'User already exists with this email!';
            } else {
               // Check if an admin already exists
               if ($user_type == 'admin') {
                   $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                   
                   // If there's already an admin, prevent new admin registration
                   if (mysqli_num_rows($select_admin) > 0) {
                       $message[] = 'An admin already exists. Only one admin can be registered.';
                   } else {
                       // Insert new user into the database
                       mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('query failed');
                       $message[] = 'Registered successfully!';
                       header('location:login.php');
                       exit;
                   }
               } else {
                   // If not an admin, just insert the user
                   mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('query failed');
                   $message[] = 'Registered successfully!';
                   header('location:login.php');
                   exit;
               }
            }
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
   <title>Register</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
// Display any messages (errors or success)
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</div>

</body>
</html>
