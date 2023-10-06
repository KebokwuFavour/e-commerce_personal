<?php

// the file for keys
require '../../index.env.php';
$SecretKey = $apiSecretKey;

$curl = curl_init();

// check if the request to this page is a valid request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the JSON data from the request body and decode it
  $json_data = file_get_contents("php://input");
  $data = json_decode($json_data);

  // Check if the JSON data was successfully decoded
  if ($data !== null) {
    $reference = $data->reference;
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer " . $SecretKey,
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Set the content type header
    header('Content-Type: application/json');

    // Parse the JSON response from the Paystack API
    $responseData = json_decode($response, true);

    // Check if the response is valid JSON
    if ($responseData !== null) {

      // header('content-type: application/json'); // Set the content type header
      echo json_encode($responseData);
    } else {

      // Handle JSON parsing error
      echo json_encode(["status" => "Error: Invalid JSON response"]);
    }

    if ($err) {

      http_response_code(500); // Set a 500 Internal Server Error status code
      echo json_encode(["status" => "Error: cURL Error #" . $err]);
    }
  } else {

    // Data is null
    echo json_encode(["status" => "Error: Data is null"]);
  }
} else {

  // Invalid request Method
  echo json_encode(["status" => "Error: Invalid Request Method"]);
}
