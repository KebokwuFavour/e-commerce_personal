<?php

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "my_e-commerce";

try {
  // Connect to the database using the loaded environment variables
  $con = new PDO("mysql:host=$serverName; dbname=$dbName", $userName, $password);

  // Set default mode for fetching data (optional)
  $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  // Set PDO error mode to exception
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $con;
} catch (PDOException $e) {
  error_log("Database Error: " . $e->getMessage());
  echo json_encode(["status" => "error", "error" => $e->getMessage()]);
}
