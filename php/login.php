<?php

// Check if data is sent
if (!isset($_POST['username']) || !isset($_POST['password'])) {

  // Return error
  header('Content-Type: application/json');
  echo json_encode(['error' => 'error']);
}

// Connect to database
require_once('../init.php');

$conn = new DBConnection();
$conn = $conn->connect();

// Fetch user data from database
$sql = "SELECT id, username, password, role FROM users WHERE username = :username";

$stmt = $conn->prepare($sql);

$params = ['username' => $_POST['username']];

if (!$stmt->execute($params)) {
  // Return error
  header('Content-Type: application/json');
  echo json_encode(['error' => $stmt->errorInfo]);
};

$user = $stmt->fetch();

// Compare user and database password
if (password_verify($_POST['password'], $user->password)) {

  // Turn on session variables
  $_SESSION['user'] = (object) [
    'id' => $user->id,
    'username' => $user->username,
    'role' => $user->role,
  ];

  redirect('/dashboard.php');
} else {
  // password does not match
  redirect('/');
}

$stmt = null;
exit();
