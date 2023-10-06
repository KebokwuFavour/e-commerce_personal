<?php

// database connection file
require_once "../db_connect.php";

// check if the request to this page is a valid request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the JSON data from the request body and decode it
  $json_data = file_get_contents("php://input");
  $data = json_decode($json_data);

  // Check if the JSON data was successfully decoded
  if ($data !== null) {
    $reference = $data->reference;
    $user_id = $data->user_id;
    $user_email = $data->user_email;
    $user_name = $data->user_name;
    $total_amount = $data->total_amount;
    $user_ip = $_SERVER["REMOTE_ADDR"];

    function generateInvoiceID($length)
    {
      $characters = '0123456789';
      $invoice = '';

      // Append a timestamp component
      $invoice .= time();

      // Calculate how many characters are left to reach the desired length
      $remainingLength = $length - strlen($invoice);

      // Generate random alphanumeric characters for the remaining length
      for ($i = 0; $i < $remainingLength; $i++) {
        $invoice .= $characters[rand(0, strlen($characters) - 1)];
      }

      return $invoice;
    }

    $invoice_id = generateInvoiceID(16);

    // Set the content type header
    header('Content-Type: application/json');

    // insert data into db
    $insertData = $con->prepare("INSERT INTO user_transaction_details (u_user_id, u_name, u_user_email, total_amt, reference_id, invoice_id, u_ip_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertData->execute([$user_id, $user_name, $user_email, $total_amount, $reference, $invoice_id, $user_ip]);

    if ($insertData) {

      // select from user carts table in the db
      $select = $con->prepare("SELECT * FROM user_carts WHERE user_id = ?");
      $select->execute([$user_id]);
      $result = $select->fetchAll();

      foreach ($result as $dataInfo) {

        $prod_id = $dataInfo["prod_id"];
        $prod_name = $dataInfo["prod_name"];
        $price = $dataInfo["price"];
        $prod_quantity = $dataInfo["prod_quantity"];
        $total_price = $dataInfo["total_price"];
        // insert data into db
        $insertData2 = $con->prepare("INSERT INTO user_transaction_details_products (u_user_id, u_user_email, u_name, u_purchased_prods, price, u_p_prods_quantity, total_price, u_p_prods_id, invoice_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertData2->execute([$user_id, $user_email, $user_name, $prod_name, $price, $prod_quantity, $total_price, $prod_id, $invoice_id]);

        if ($insertData2) {

          // Success: Data inserted
          echo json_encode(["status" => "success... Data inserted successfully"]);
        } else {

          // Error: Data not inserted
          error_log("Database Error: " . json_encode($errorInfo));
          echo json_encode(["status" => "error!", "error" => "isError!"]);
          echo json_encode(["Database Error:" => "database error!"]);
        }

        $insertData2 = null;
      }

      // Success: Data inserted
      echo json_encode(["status" => "success. Data inserted successfully"]);
    } else {

      // Error: Data not inserted
      error_log("Database Error: " . json_encode($errorInfo));
      echo json_encode(["status" => "error", "error" => "isError"]);
      echo json_encode(["Database Error:" => "database error"]);
    }

    $insertData = null;
  } else {

    // Error: Data is null
    echo json_encode(["status" => "error. Data is null"]);
  }
} else {

  // Error: Data is null
  echo json_encode(["status" => "error. Invalid Request"]);
}
