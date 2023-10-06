<?php

session_start();

// the db file
require_once "../db_connect.php";

/**
 * Handler for adding items to cart *
 **/

// Check if the add to cart button is clicked
if (isset($_POST["add_cart_btn"])) {

  if (isset($_SESSION["uName"])) {

    // User is signed in and valid, save cart data in db

    // Get the product id
    $pId = $_POST["identifier"];

    // check for the product details based on the id
    $select_p = $con->prepare("SELECT * FROM products where prod_id = ?");
    $select_p->execute([$pId]);
    $info = $select_p->fetchAll();

    // assign required info to respective variables
    $name = $info[0]["prod_name"];
    $quantity = 1;

    // check if the product has a discount price or not
    $price = (isset($info[0]["prod_discount_price"]) && !empty($info[0]["prod_discount_price"])) ? $info[0]["prod_discount_price"] : $info[0]["prod_price"];

    $t_price = (isset($info[0]["prod_discount_price"]) && !empty($info[0]["prod_discount_price"])) ? $info[0]["prod_discount_price"] * $quantity : $info[0]["prod_price"] * $quantity;

    // check if the product has an alt name or not and assign it to a variable
    $alt_name = (isset($info[0]["alt_name"]) && !empty($info[0]["alt_name"])) ? $info[0]["alt_name"] : "";

    $userId = $_SESSION["uid"];

    // check if product exists in the cart db
    $select_c = $con->prepare("SELECT * FROM user_carts WHERE prod_id = ? AND user_id = ?");
    $select_c->execute([$pId, $userId]);
    $data_c = $select_c->fetchAll();
    // $data_c = $select_c;

    if ($data_c) {

      // product already added to cart, return to previous page with a message
      $msg = "Product already added to cart previously";
      header("location: ../../index.php" . $msg);
    } else {

      // product does not exist in the cart db. Add it
      $insert = $con->prepare("INSERT INTO user_carts (prod_id, prod_name, price, prod_quantity, total_price, prod_alt_name, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $insert->execute([$pId, $name, $price, $quantity, $t_price, $alt_name, $userId]);

      if ($insert) {

        // return to previous page with a success message
        $msg = "Product added to cart successfully!";
        header("location: ../../index.php" . $msg);
      }

      $insert = null;
    }
  } else {

    // User is not signed in and not valid, save cart in cookie

    // Product identifier
    $product_id = $_POST["identifier"];
    $quantity = 1; // Default quantity to add

    // Check if the cart array exists in cookies, and create it if not
    $cart = (!isset($_COOKIE["cart"])) ? [] : json_decode($_COOKIE["cart"], true);

    // Check if the product already exists in the cart
    if (isset($cart[$product_id])) {

      // Product already in cart; update the quantity
      $cart[$product_id] += $quantity;

      // $msg = "Item already added to cart previously";
      $msg = "Item updated in cart successfully";
    } else {

      // Product not in cart; add the item
      $cart[$product_id] = $quantity;
      $msg = "Item added to cart successfully";
    }

    // Set the updated cart data as a cookie
    setcookie("cart", json_encode($cart), time() + 86400, "/", '', true, true);
  }

  // Redirect back to the previous page with the appropriate message
  header("location: ../../index.php?message=" . $msg);
} else {

  // redirect user back to home page
  header("loaction: ../../index.php");
}


/**
 * Handler for deleting items from cart when user is logged in *
 **/

if (isset($_POST["del_c"])) {

  // get the product cart id
  $id = $_POST["cId"];

  // delete the product with the id from the cart table in the db
  $del = $con->prepare("DELETE FROM user_carts WHERE cart_id = ?");
  $del->execute([$id]);

  if ($del) {

    // redirection message
    $msg = "product successfully deleted from your cart!";
  } else {

    // redirection message
    $msg = "Unable to delete the product from your cart!";
  }

  // return to previuos page with the message
  header("location: ../../cart_items.php?note=" . $msg);
}


/**
 * Handler for deleting items from cart when user is not logged in *
 **/

if (isset($_POST["delete"])) {

  // get the product cart id
  $pid = $_POST["pId"];

  if (isset($_COOKIE["cart"])) {

    // decode the cart data
    $cartCookie = $_COOKIE["cart"];
    $cart_data = json_decode($cartCookie, true); // true; to get an associative array

    if (isset($cart_data[$pid])) {

      // unset the cart data with the product id
      unset($cart_data[$pid]);
    }

    // update the cookie
    $cartCookie = json_encode($cart_data);
    setcookie('cart', $cartCookie, time() + 3600, '/', '', true, true);

    // redirection message
    $msg = "wproduct successfully deleted from your cart!";

    // return back to previous page with a message
    header("location: ../../cart_items.php?note=" . $msg);
  }
}


/**
 * Handler for updating cart product quantity when user is not logged in *
 **/

if (isset($_POST["save_cart_changes"])) {

  $prodId = $_POST["cpid"];
  $quantity = $_POST['quantityCo'];

  // update cookie with the quantity
  $cartCookie = json_decode($_COOKIE["cart"], true);
  $cartCookie[$prodId] = $quantity;

  // Set the updated cart data as a cookie
  setcookie("cart", json_encode($cartCookie), time() + 86400, "/", '', true, true);

  // return to previous page with a message
  $msg = "Product quantity updated successfully";
  header("location: ../../cart_items.php");
}


/**
 * Handler for updating cart product quantity when user is logged in *
 **/

if (isset($_POST["save_changes"])) {

  $prodId = $_POST["scpid"];
  $quantity = $_POST['quantitySes'];
  $price = $_POST['scprice'];

  $total = $price * $quantity;

  // update cart table in the db with the quantity
  $updateCartProd = $con->prepare("UPDATE user_carts SET prod_quantity  = ?, total_price = ? WHERE prod_id = ?");
  $updateCartProd->execute([$quantity, $total, $prodId]);

  if ($updateCartProd) {

    // return to previous page with a message
    $msg = "Product quantity updated successfully";
    header("location: ../../cart_items.php");
  }

  $updateCartProd = null;
}
