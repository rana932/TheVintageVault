<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p><a href="login.php">Login</a> | <a href="register.php">Register</a>  | <a href="logout.php">Logout</a></p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
	     <a href="home.php">
	     <img src="images/logo.png" alt="TheVintageVault" class="logo">
        </a>

         <nav class="navbar">
            <a href="home.php">HOME</a>
            <a href="about.php">ABOUT</a>
            <a href="shop.php">SHOP</a>
            <a href="contact.php">CONTACT</a>
            <a href="orders.php">ORDERS</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="icons">
            <p><small><i class="fa fa-user-circle"></i> <span><?php echo $_SESSION['user_name']; ?></span></small></p>
            <p><small><i class="fa fa-envelope"></i> <span><?php echo $_SESSION['user_email']; ?></span></small></p>

         </div>
      </div>
   </div>

</header>