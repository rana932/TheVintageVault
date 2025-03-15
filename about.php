<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>At our antique store, we offer more than just unique, timeless treasures — we provide an experience you can trust.<br>
		    Our carefully curated collection features high-quality, authentic antiques that tell a story, each piece handpicked for its craftsmanship and history.<br>
            🛒 Shop Online with Confidence – Browse, buy, and enjoy hassle-free online shopping.<br>
            🚚 Doorstep Delivery – Delivered securely to your home with utmost care.<br>
            Start your journey into the past today and own a piece of history!</p>

         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>


<?php include 'footer.php'; ?>


</body>
</html>