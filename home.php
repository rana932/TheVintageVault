<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // Check if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    // Check if the user already has the product in the cart
    if (mysqli_num_rows($check_cart_numbers) > 0) {
        // Fetch the current quantity of that product in the cart
        $fetch_cart = mysqli_fetch_assoc($check_cart_numbers);
        $existing_quantity = $fetch_cart['quantity'];

        // Calculate the new total quantity of the product in the cart
        $new_quantity = $existing_quantity + $product_quantity;

        if ($new_quantity > 5) {
            $message[] = 'You cannot add more than 5 units of a product to the cart!';
        } else {
            // Update the quantity of the product in the cart
            mysqli_query($conn, "UPDATE `cart` SET quantity = '$new_quantity' WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
            $message[] = 'Product quantity updated in cart!';
        }
    } else {
        // If the product is not in the cart, add it with the given quantity
        if ($product_quantity <= 5) {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
            $message[] = 'Product added to cart!';
        } else {
            $message[] = 'You cannot add more than 5 units of a product to the cart!';
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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Hand Picked Items to your door.</h3>
      <p>At The Vintage Vault, we believe that every antique has a story to tell. Our passion for preserving history drives us to create a vibrant online marketplace where collectors, enthusiasts, and casual buyers can connect with unique pieces from the past.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price"> ₹<?php echo $fetch_products['price']; ?>/-</div>
      <input type="number" min="1" max="5" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Welcome to The Vintage Vault – Where Timeless Treasures Find Their Way to Your Doorstep.<br>
            Discover a curated collection of antique items from around the world, available at your fingertips. 
			Whether you're searching for a rare artifact, a vintage collectible, or a one-of-a-kind masterpiece, we bring history to your home with ease.
         </p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Whether you're looking to sell a cherished heirloom or find that perfect vintage decor item, The Vintage Vault is your trusted partner in navigating the world of antiques. Explore our collection today and uncover the timeless treasures waiting just for you!</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>

<?php include 'footer.php'; ?>

</body>
</html>
