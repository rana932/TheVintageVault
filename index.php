<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>index</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header2.php'; ?>


<section class="home">

   <div class="content">
      <h3>Hand Picked Items to your door.</h3>
      <p>At The Vintage Vault, we believe that every antique has a story to tell. Our passion for preserving history drives us to create a vibrant online marketplace where collectors, enthusiasts, and casual buyers can connect with unique pieces from the past.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>


<!-- Products Section -->
<section class="products">
   <h1 class="title">Latest Products</h1>

   <div class="box-container">
      <?php  
         // Fetch products from the database
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price"> ₹<?php echo $fetch_products['price']; ?>/-</div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Load More</a>
   </div>

</section>

<?php include 'footer.php'; ?>

</body>
</html>
