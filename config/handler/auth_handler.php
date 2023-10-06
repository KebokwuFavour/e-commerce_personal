<?php

// require the db file
require_once "../db_connect.php";

// function for validating user input data
function InputCheck($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}


/* ***************************************** Handler for user signup ****************************************** */
// Handler for user signup
if (isset($_POST["signup"])) {

  // validate input
  $name = InputCheck($_POST["name"]);
  $email = InputCheck(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));
  $username = InputCheck($_POST["username"]);
  $password = $_POST["password"];
  $TandC = $_POST["TandC"];

  if (!isset($_POST["name"]) || empty($_POST["name"])) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?nameErr");
  } elseif (!preg_match("/^[ a-zA-Z]*$/", $name)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?nameErr");
  } elseif (!isset($email) || empty($email)) {
    // redirect to signup page with an error

    header("location: ../../auth/signup.php?emailErr");
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?emailErr");
  } elseif (!isset($username) || empty($username)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?usernameErr");
  } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?usernameErr");
  } elseif (!isset($password) || empty($password)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?passwordErr");
  } elseif (!isset($TandC) || empty($TandC)) {

    // redirect to signup page with an error
    header("location: ../../auth/signup.php?TandCErr");
  } else {

    // check if email and username already exist
    $selectU = $con->prepare("SELECT * FROM users where email = ? OR username = ?");
    $selectU->execute([$email, $username]);
    $resultU = $selectU->fetchAll();

    if ($email === $resultU[0]['email']) {

      // redirect to signup page with the error
      header("location: ../../auth/signup.php?Eexistaii");
    } elseif (isset($resultU[0]['username']) and $resultU[0]['username'] === $username) {

      // redirect to signup page with the error
      header("location: ../../auth/signup.php?Unexistaii");
    } else {

      // Insert data into database
      $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
      $insert = $con->prepare("INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)");
      $insert->execute([$name, $email, $username, $password]);

      if ($insert) {

        // redirect user to signin page with a success message to continue
        $msg = "success";
        header("location: ../../auth/signin.php?" . $msg);
      } else {

        // redirect user to signup page with an error message
        $msg = "error";
        header("location: ../../auth/signup.php?" . $msg);
      }

      $insert = null;
    }
  }
}



/* ***************************************** Handler for user signin ****************************************** */
// Handler for user signin
if (isset($_POST["signin"])) {

  // check valididty of the input and sanitize
  $userName = InputCheck($_POST["userName"]);
  $pwd = $_POST["pwd"];

  if (!isset($userName) || empty($userName)) {

    // redirect to signup page with an error
    header("location: ../../auth/signin.php?usernameErr");
  } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $userName)) {

    // redirect to signup page with an error
    header("location: ../../auth/signin.php?usernameErr");
  } elseif (!isset($pwd) || empty($pwd)) {

    // redirect to signup page with an error
    header("location: ../../auth/signin.php?passwordErr");
  } else {

    // check if username exist in the db
    $select = $con->prepare("SELECT * FROM users WHERE username = ?");
    $select->execute([$userName]);
    $result = $select->fetchAll();
    if ($select) {

      // retrieve password
      $dbPwd = $result[0]['password'];
      $verifyPwd = password_verify($pwd, $dbPwd);

      if ($verifyPwd == 1) {

        // user is valid and now active
        session_start();
        $_SESSION["uid"] = $result[0]["user_id"];
        $_SESSION["uuName"] = $result[0]["username"];
        $_SESSION["uName"] = $result[0]["name"];
        $_SESSION["uEmail"] = $result[0]["email"];
        $uid = $result[0]["user_id"];
        $uname = $result[0]["username"];
        $uemail = $result[0]["email"];
        $sessionId = session_Id();
        $insert = $con->prepare("INSERT INTO active_users (user_id, username, email, session_id) VALUES (?, ?, ?, ?)");
        $insert->execute([$uid, $uname, $uemail, $sessionId]);

        if (isset($insert)) {

          if (isset($_COOKIE["cart"])) {

            // merge cart items in the cookie with the one in the database:

            // decode the json string from the cart cookie into an array
            $cart_data = json_decode($_COOKIE["cart"], true);

            // loop through so as to get datas from the assoc array
            foreach ($cart_data as $product_id => $quantity) {

              // save in variable and merge with the database cart items for good user experience
              $prod_id = $product_id;
              $prod_quantity = $quantity;
              $user = $_SESSION["uid"];

              // check the cart table in the db if product exist;

              // if the product exist in the db, update it. If not insert it
              $select_c = $con->prepare("SELECT * FROM user_carts where prod_id = ? AND user_id = ?");
              $select_c->execute([$prod_id, $user]);
              $result_c = $select_c->fetchAll();

              // get the actual price of the product in the products table
              $select_p = $con->prepare("SELECT * FROM products where prod_id = ?");
              $select_p->execute([$prod_id]);
              $result_p = $select_p->fetchAll();

              if ($result_c) {

                // Update the cart product quantity and prices
                if (isset($result_p[0]["prod_discount_price"]) && !empty($result_p[0]["prod_discount_price"])) {

                  // calculate new price if there is a discount price
                  $unit_price = $result_p[0]["prod_discount_price"];
                } else {

                  // calculate the new price as well if there is no discount price
                  $unit_price = $result_p[0]["prod_price"];
                }

                $new_quantity = $result_c[0]["prod_quantity"] + $prod_quantity;

                if (isset($result_p[0]["prod_discount_price"]) && !empty($result_p[0]["prod_discount_price"])) {

                  // calculate new price if there is a discount price
                  $total_price = $result_p[0]["prod_discount_price"] * $new_quantity;
                } else {

                  // calculate the new price as well if there is no discount price
                  $total_price = $result_p[0]["prod_price"] * $new_quantity;
                }

                $identity = $_SESSION["uid"];

                $update = $con->prepare("UPDATE user_carts SET price = ?, prod_quantity = ?, total_price = ? WHERE user_id = ? AND prod_id = ?");
                $update->execute([$unit_price, $new_quantity, $total_price, $identity, $prod_id]);

                if ($update) {

                  // Set a success message for redirection when neccessary
                  $msg = "successu";
                }
              } else {

                // Product does not exist in the db. Insert it as a new row
                $prod_name = $result_p[0]["prod_name"];

                if (isset($result_p[0]["prod_discount_price"]) && !empty($result_p[0]["prod_discount_price"])) {

                  // if there is a discount price
                  $price = $result_p[0]["prod_discount_price"];
                } else {

                  // if there is no discount price
                  $price = $result_p[0]["prod_price"];
                }

                if (isset($result_p[0]["prod_discount_price"]) && !empty($result_p[0]["prod_discount_price"])) {

                  // calculate new price as well if there is a discount price
                  $t_price = $result_p[0]["prod_discount_price"] * $prod_quantity;
                } else {

                  // calculate the new price as well as well if there is no discount price
                  $t_price = $result_p[0]["prod_price"] * $prod_quantity;
                }

                $alt_name = $result_p[0]["alt_name"];
                $userId = $_SESSION["uid"];

                $insert_c = $con->prepare("INSERT INTO user_carts (prod_id, prod_name, price, prod_quantity, total_price, prod_alt_name, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insert_c->execute([$prod_id, $prod_name, $price, $prod_quantity, $t_price, $alt_name, $userId]);

                // $success = ($insert_c) ? 1 : 0;

                if ($insert_c) {

                  // Set a success msg for redirection when neccessary
                  $msg = "successi";
                }
              }

              $select_p = null;
              $select_c = null;
            }

            if ($update || $insert_c) {

              // Delete cookie
              setcookie("cart", "", time() - 60, '/');
              $msg = "C_Sync";
            }

            $update = null;
            $insert_c = null;

            // redirect user to home page with a success message to continue
            header("location: ../../index.php?" . $msg);
          } else {

            // redirect user to home page with a success message to continue
            $msg = "success";
            header("location: ../../index.php?" . $msg);
          }
        } else {

          // redirect user to signin page with an error message
          $msg = "undefined";
          header("location: ../../auth/signin.php?" . $msg);
        }

        $insert = null;
      } else {

        // redirect to signin page with an error
        header("location: ../../auth/signin.php?passwordErr");
      }
    }
  }
}
