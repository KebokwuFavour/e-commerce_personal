<?php
session_start();

// the db file
require_once "config/db_connect.php";

if (isset($_GET["message"])) {
  echo "<script> alert('" . $_GET["message"] . "'); </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Add to cart and purchase skill showcase</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="#!">GUY</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="#dropdown" aria-expanded="false">Shop</a>
            <ul class="dropdown-menu" id="dropdown" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#!">All Products</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li><a class="dropdown-item" href="#!">Popular Items</a></li>
              <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
            </ul>
          </li>
        </ul>

        <div class="d-flex">

          <?php
          if (isset($_SESSION["uName"])) {

            // display user logout button and username
          ?>

            <a href="auth/signout.php" class="btn btn-outline-danger mx-2">
              <!-- <i class="bi-cart-fill me-1"></i> -->
              SignOut
            </a>
            <a href="#profile.php" class="text-decoration-none">

              <?php

              echo $_SESSION["uName"];

              ?>

            </a>

            <a href="cart_items.php" class="btn btn-outline-dark mx-2">
              <i class="bi-cart-fill me-1"></i>
              Cart
              <span class="badge bg-dark text-white ms-1 rounded-pill">

                <?php
                $count = $con->prepare("SELECT * FROM user_carts WHERE user_id = ?");
                $count->execute([$_SESSION["uid"]]);
                $num = $count->rowCount();

                if (isset($num)) {

                  // display the total amount of cart value
                  echo $num;
                }

                ?>

              </span>
            </a>

          <?php

          } else {

            // display signin and signup button
          ?>

            <a href="auth/signin.php" class="btn btn-outline-success mx-2">
              <!-- <i class="bi-cart-fill me-1"></i> -->
              Signin
            </a>
            <a href="auth/signup.php" class="btn btn-outline-primary mx-2">
              <!-- <i class="bi-cart-fill me-1"></i> -->
              Signup
            </a>

            <a href="cart_items.php" class="btn btn-outline-dark mx-2">
              <i class="bi-cart-fill me-1"></i>
              Cart
              <span class="badge bg-dark text-white ms-1 rounded-pill">

                <?php

                if (isset($_COOKIE['cart'])) {
                  // display the total amount of cart value
                  $cart = json_decode($_COOKIE["cart"], true);
                  echo count($cart);
                }

                ?>

              </span>
            </a>

          <?php
          }
          ?>

        </div>
      </div>
    </div>
  </nav>
  <!-- Header-->
  <header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Add items to Cart and buy from Cart</h1>
        <p class="lead fw-normal text-white-50 mb-0">Add to cart while not logged in and while logged in</p>
      </div>
    </div>
  </header>

  <?php
  $select_prods = $con->prepare("SELECT * FROM products");
  $select_prods->execute();
  $results = $select_prods;
  ?>
  <!-- Section-->
  <section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
      <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

        <?php
        // show the data here...
        foreach ($results as $result) {
          // display correspoonding $result data:
        ?>

          <div class="col mb-5">
            <div class="card h-100">
              <!-- Sale badge-->
              <?php
              if (empty($result["prod_quantity"]) or $result["prod_quantity"] == null or $result["prod_quantity"] == "") {
                // product sold out
              ?>
                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                  Sold Out
                </div>
              <?php
              } else {
                // product on sale
              ?>
                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                  On Sale
                </div>
              <?php
              }
              ?>

              <!-- Product image-->
              <img class="card-img-top" src="assets/prodcut_images/<?php echo $result["prod_image"] ?>" alt="product image" />
              <!-- Product details-->
              <div class="card-body p-4">
                <div class="text-center">

                  <!-- Product name-->
                  <h5 class="fw-bolder"><?php echo $result["prod_name"] ?></h5>
                  <?php
                  if (isset($result["alt_name"])) {
                    // show alt_name
                  ?>
                    <p class="small"><em><?php echo $result["alt_name"] ?></em></p>
                  <?php
                  }
                  ?>
                  <!-- Product reviews-->
                  <div class="d-flex justify-content-center small text-warning mb-2">
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                  </div>
                  <!-- Product price-->
                  <?php
                  if (empty($result["prod_discount_price"]) or $result["prod_discount_price"] == null or $result["prod_discount_price"] == "") {

                    // product sold out
                    echo "$" . $result["prod_price"];
                  } else {
                    // product on sale
                  ?>

                    <span class="text-muted text-decoration-line-through"><?php echo "$" . $result["prod_price"] ?></span>
                    <?php echo "$" . $result["prod_discount_price"] ?>

                  <?php
                  }
                  ?>

                </div>
              </div>
              <!-- Product actions-->
              <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center">
                  <!-- <a class="btn btn-outline-dark mt-auto" href="config/handler/cart_handler.php">Add to cart</a> -->
                  <form action="config/handler/cart_handler.php" method="post">
                    <input type="hidden" name="identifier" value="<?php echo $result["prod_id"] ?>">
                    <button type="submit" name="add_cart_btn" class="btn btn-outline-dark mt-auto">Add to cart</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>

      </div>
    </div>
  </section>

  <!-- Footer-->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy;2023. Developed By <a href="https://www.kebokwu-favour.netlify.app">Kebokwu Favour</a></p>
    </div>
  </footer>
  <!-- Bootstrap core JS-->
  <script src="js/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>

</html>