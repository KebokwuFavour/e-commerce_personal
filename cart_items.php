<?php

session_start();

// the db file
require "config/db_connect.php";

if (isset($_GET["note"])) {

  // alert it
  echo "<script> alert('" . $_GET["note"] . "'); </script>";
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

  <script src="https://js.paystack.co/v1/inline.js"></script>
</head>

<body>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="#!">GUY</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
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
          if (isset($_SESSION["uuName"])) {

            // display user logout button and username
          ?>

            <a href="auth/signout.php" class="btn btn-outline-danger mx-2">
              <!-- <i class="bi-cart-fill me-1"></i> -->
              SignOut
            </a>
            <a href="#profile.php" class="text-decoration-none">

              <?php

              echo $_SESSION["uuName"];

              ?>

            </a>

            <a href="cart_items.php" class="btn btn-outline-dark mx-2">
              <i class="bi-cart-fill me-1"></i>
              Cart
              <span class="badge bg-dark text-white ms-1 rounded-pill">

                <?php
                $uid = $_SESSION["uid"];
                $count = $con->prepare("SELECT * FROM user_carts WHERE user_id = ?");
                $count->execute([$uid]);
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

  <div class="container py-5">
    <div class="row">
      <div class="col-md-12">


        <?php

        // check if user is signed in and valid
        if (isset($_SESSION["uuName"])) {

          // user is signed in and valid
        ?>

          <?php

          // display user cart data
          $select = $con->prepare("SELECT * FROM user_carts WHERE user_id = ?");
          $select->execute([$uid]);
          $c_data = $select->fetchAll();

          if ($c_data) {
          ?>

            <table class="table table-striped table-hover border">

              <thead>
                <tr class="text-center">
                  <th class="border">#</th>
                  <th class="border">Name</th>
                  <th class="border">Price</th>
                  <th class="border">Quantity</th>
                  <th class="border">Total</th>
                  <th class="border">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $i = 1;

                // display neccessary data
                foreach ($c_data as $info) {

                  // display all the info$info stored in the cart table using a table
                ?>

                  <form action="config/handler/cart_handler.php" method="post">
                    <tr class="text-center">

                      <td class="border">

                        <?php echo $i++ ?>

                      </td>

                      <td class="border">

                        <?php echo $info["prod_name"] ?>

                        <br>
                        <small>

                          <?php echo "<i>" . $info["prod_alt_name"] . "</i>" ?>

                        </small>

                      </td>

                      <td class="border">

                        $<?php echo number_format($info["price"], 2, ".", ",") ?>

                      </td>

                      <td class="border" style="width: 150px;">
                        <input type="number" name="quantitySes" id="#" value="<?php echo $info["prod_quantity"] ?>" min="1" class="form-control text-center">
                      </td>

                      <td class="border">

                        <?php

                        echo "$" . number_format($info["total_price"], 2, ".", ",");

                        ?>

                      </td>

                      <td class="border" style="width: 250px">
                        <input type="hidden" name="scpid" value="<?php echo $info["prod_id"] ?>">
                        <input type="hidden" name="scprice" value="<?php echo $info["price"] ?>">
                        <button type="submit" class="btn btn-md btn-outline-secondary mb-2 mb-md-0" name="save_changes">
                          Save Changes
                        </button>

                        <!-- delete modal button -->
                        <button type="button" class="btn btn-md btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                          Delete
                        </button>
                      </td>

                    </tr>
                  </form>

                <?php

                }

                // Get the total price of each particular product
                $select_ct = $con->prepare("SELECT SUM(total_price) FROM user_carts WHERE user_id = ?");
                $select_ct->execute([$uid]);
                $total = $select_ct->fetchColumn();

                if (isset($total)) {

                  // Display total of total price table data
                ?>
                  <td class="border text-end" colspan="4">
                    <strong>Total</strong>
                  </td>
                  <td class="border text-center">
                    <strong>$<?php echo number_format($total, 2, ".", ",") ?></strong>
                    <!-- <strong>$00.00</strong> -->
                  </td>
                  <td class="border text-center"></td>
              </tbody>

            <?php

                }

            ?>

            </table>
            <div class="row pt-3">
              <div class="col-12">
                <div class="d-flex space-between">
                  <div class="col-6 text-center">
                    <a href="index.php" class="btn btn-primary">
                      Continue Shopping
                    </a>
                  </div>
                  <div class="col-6 text-center">
                    <form id="paymentForm">
                      <input type="hidden" id="amount" name="t_amt" value="<?php echo number_format($total, 2, ".", ",") ?>">
                      <input type="hidden" id="email-address" name="u_email" value="<?php echo $_SESSION["uEmail"] ?>">
                      <input type="hidden" id="name" name="u_name" value="<?php echo $_SESSION["uName"] ?>">
                      <input type="hidden" id="uID" name="user_id" value="<?php echo number_format($uid) ?>">
                      <button type="button" id="checkout-button" class="btn btn-success" style="width: 170px; color: white;" onclick="payWithPaystack()">
                        Checkout
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php

          } else {

            // notify the user that there is no product added to cart
            echo "<h3 class='text-secondary text-center'> No product in the cart currently. Products added to cart will display here </h3>";
          }
        } else {

          //  user is not signed in/not valid

          // check if cart cookies exist
          if (isset($_COOKIE["cart"])) {

          ?>

            <table class="table table-striped table-hover border">
              <thead>
                <tr class="text-center">
                  <th class="border">#</th>
                  <th class="border">Name</th>
                  <th class="border">Price</th>
                  <th class="border">Quantity</th>
                  <th class="border">Total Price</th>
                  <th class="border">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                // decode the json string from the cart cookie into an array
                $cart = json_decode($_COOKIE["cart"], true);

                $i = 1;
                $total = 0;

                // loop through the decoded json string to access required datas from the cookie
                foreach ($cart as $product_id => $quantity) {

                  $prod_id = $product_id;
                  $prod_quantity = $quantity;

                  // select respective products from database
                  $select = $con->prepare("SELECT * FROM products WHERE prod_id = ?");
                  $select->execute([$prod_id]);
                  $result = $select;

                  foreach ($result as $data) {

                    // display all the data stored in the cookie using a table
                ?>

                    <form action="config/handler/cart_handler.php" method="post">
                      <tr class="text-center">
                        <td class="border"><?php echo $i++ ?></td>
                        <td class="border"><?php echo $data["prod_name"] ?></td>
                        <td class="border">

                          <?php

                          if (isset($data["prod_discount_price"]) &&  !empty($data["prod_discount_price"]) && $data["prod_discount_price"] != "") {

                            // echo the discount price not the main price
                            echo number_format($data["prod_discount_price"], 2, ".", ",");
                            $price = $data["prod_discount_price"];
                          } else {

                            // echo the main price not the product price
                            echo number_format($data["prod_price"], 2, ".", ",");
                            $price = $data["prod_price"];
                          }

                          ?>

                        </td>
                        <td class="border" style="width: 150px;">
                          <input type="number" name="quantityCo" id="#" value="<?php echo $prod_quantity ?>" class="form-control text-center">
                        </td>
                        <td class="border"><?php echo number_format($prod_quantity * $price, 2, ".", ",") ?></td>
                        <td class="border">

                          <input type="hidden" name="cpid" value="<?php echo $data["prod_id"] ?>">
                          <button type="submit" class="btn btn-md btn-secondary" name="save_cart_changes">
                            Save Changes
                          </button>

                          <!-- modal button for deleting cookie modal -->
                          <button type="button" class="btn btn-md btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop2<?php echo $data["prod_id"] ?>">
                            Delete
                          </button>

                        </td>
                      </tr>
                    </form>

                    <!-- Modal for cart cookie delete -->
                    <div class="modal fade" id="staticBackdrop2<?php echo $data["prod_id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete this product from your cart? <br> This action cannot be undone!
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="config/handler/cart_handler.php" method="post">
                              <input type="hidden" name="pId" value="<?php echo $data["prod_id"] ?>">
                              <input type="submit" name="delete" id="#" value="Delete" class="btn btn-md btn-outline-danger">
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End of modal for cart cookie delete -->

                <?php

                    $sum_total = $prod_quantity * $price;
                    $total += $sum_total;
                  }
                }

                // Display total of total price table data
                ?>

                <td class="border text-end" colspan="4">
                  <strong>Total</strong>
                </td>
                <td class="border text-center">
                  <!-- <strong>$</?php echo $total ?></strong> -->
                  <strong>$<?php echo number_format($total, 2, ".", ","); ?></strong>
                </td>
                <td class="border text-center"></td>
              </tbody>
            </table>

            <div class="row pt-3">
              <div class="col-12">
                <div class="d-flex space-between">

                  <div class="col-6 text-center">
                    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                  </div>

                  <div class="col-6 text-center">
                    <!-- modal button -->
                    <button type="button" class="btn btn-success" style="width: 170px; color: white;" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                      Checkout
                    </button>

                    <!-- modal for checkout button when user is not signed in -->
                    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            You must signin to be able to checkout.<br>Do well to signin now to proceed.
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="auth/signin.php" class="btn btn-md btn-outline-danger">SignIn</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End of modal for checkout button when user is not signed in -->
                  </div>
                </div>
              </div>
            </div>

        <?php

          } else {

            // notify the user that there is no product added to cart
            echo "<h3 class='text-secondary text-center'> No product in the cart currently. Products added to cart will display here </h3>";
          }
        }

        ?>

      </div>
    </div>
  </div>

  <!-- Modal for cart delete when user is signed in -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this product from your cart? <br> This cannot be undone!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <form action="config/handler/cart_handler.php" method="post">
            <input type="hidden" name="cId" value="<?php echo $info["cart_id"] ?>">
            <input type="submit" name="del_c" id="#" value="Delete" class="btn btn-md btn-outline-danger">
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End of modal for cart delete when user is signed in -->

  <!-- Footer-->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy;2023. Developed By <a href="https://www.kebokwu-favour.netlify.app">Kebokwu Favour</a></p>
    </div>
  </footer>

  <!-- Bootstrap core JS-->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <!-- Core theme JS-->


  <script src="js/bootstrap-5.3.0-dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
  <!-- <button id="checkout-button">Checkout</button> -->
  <!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->

  <?php
  function generateReference($length)
  {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $reference = '';

    // Append a timestamp component
    $reference .= time();

    // Calculate how many characters are left to reach the desired length
    $remainingLength = $length - strlen($reference);

    // Generate random alphanumeric characters for the remaining length
    for ($i = 0; $i < $remainingLength; $i++) {
      $reference .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $reference;
  }

  $refID = generateReference(16);

  // require_once 'php.env.php';
  require_once 'index.env.php';
  $PublicKey = $apiPublicKey;
  ?>

  <script>
    var paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener('submit', payWithPaystack, false);

    // payment with paystack popup function
    function payWithPaystack() {

      var handler = PaystackPop.setup({
        key: '<?php echo $PublicKey; ?>', // Replace with your public key
        email: document.getElementById('email-address').value,
        amount: document.getElementById('amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
        id: document.getElementById('uID').value,
        currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
        // ref: '' + Math.floor((Math.random() * 1000000000) + 1),
        ref: '<?php echo $refID; ?>', // Replace with a reference you generated

        callback: function(response) {

          //this happens after the payment is completed successfully
          var reference = response.reference;
          alert('Payment complete! Reference: ' + response.reference);

          // Make an AJAX call to your server with the reference to verify the transaction
          const referenceID = response.reference;
          verifyPayment(referenceID);

        },
        onClose: function() {
          alert('Transaction was not completed, window closed.');
        },
      });
      handler.openIframe();
    }

    // Verify payment function
    function verifyPayment(reference) {

      // Prepare the data to send to your server
      let data = {
        reference: reference,
      };

      // Make the AJAX call to the server to verify the payment/transaction
      fetch('config/handler/verify.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(response => {

          if (response.status === 200) {

            // Parse the JSON response so that you can access the response data
            return response.json();

          } else {

            // Handle non-200 status here
            throw new Error('Payment verification failed');
          }
        })
        .then(data => {

          // Handle the response data if needed
          if (data.status === true && data.data.status === "success") {

            // Payment verification successful

            // alert the verification message
            alert(data.message);

            // Extract payment details from the result and send them to your server to store in the database using AJAX
            const refID = data.data.reference;
            const user_id = document.getElementById('uID').value;
            const user_email = document.getElementById('email-address').value;
            const user_name = document.getElementById('name').value;
            const total_amount = document.getElementById('amount').value;

            storePaymentDetails(refID, user_id, user_email, user_name, total_amount);

          } else {

            // Payment verification failed
            alert("Payment verifications failed");
          }
        })
        .catch(error => {

          // Handle any errors that occurred during the Ajax call
          console.error("Error: ", error);
        });
    }

    // Verify payment function
    function storePaymentDetails(refID, user_id, user_email, user_name, total_amount) {

      // Prepare the data to send to your server
      let info = {
        reference: refID,
        user_id: user_id,
        user_email: user_email,
        user_name: user_name,
        total_amount: total_amount,
      };

      // Make the AJAX call to the server to verify the payment/transaction
      fetch('config/handler/store_payment.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(info)
        })
        .then(response => {

          // Handle the response from your server
          if (response.status === 200 || response.status === true || response.status === "success") {

            // Parse the JSON response so that you can access the response data
            return response.json();
          } else {

            // Payment verification failed
            alert("Payment verification failed");
          }
        })
        .then(info => {

          // Handle the response data if needed
          console.log(info.status);
        })
        .catch(error => {

          // Handle any errors that occurred during the database request
          console.log("Error storing payment details: ", error);
        });
    }
  </script>

</body>

</html>