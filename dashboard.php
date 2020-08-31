<?php

require_once 'init.php';

// Display parameters
$error = [];
$display = [];

// Get username by ID
$conn = new DBConnection();
$conn = $conn->connect();

$sql = 'SELECT * FROM trunklines';
$stmt = $conn->prepare($sql);

// $params = ['id' => $_GET['id']];

if (!$stmt->execute()) { // If fail

  $error = ['message' => $stmt->errorCode() . " : " . $stmt->errorInfo()];
} else {
  $display = ['items' => $stmt->fetchAll()];
}

?>

<!-- DISPLAY -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <?php include_script('/components/header.php'); ?>
</head>

<body>
  <?php include_script('/components/navbar.php'); ?>
  <main>

    <h1>Welcome!</h1>

    <p>This is the dashboard page.</p>

  </main>
  <?php include_script('/components/footer.php'); ?>
</body>

</html>