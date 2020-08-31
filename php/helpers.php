<?php

// Include script relative to root
function include_script($url, $return = false)
{
  require_once __DIR__ . "/..{$url}";
}

// Builds URL
function url($url = '/', $return = false)
{
  if ($return) {
    return $_ENV['APP_URL'] . $url;
  } else {
    echo ($_ENV['APP_URL'] . $url);
  }
}

// Redirect
function redirect($url = '/')
{
  header("Location: {$_ENV['APP_URL']}{$url}");
}

// Flash messages
function flash_message($url = '/', $message = '', $data = [], $status = 'ok')
{
  $payload = [
    'status' => $status,
    'message' => $message
  ];

  if (!empty($data)) {
    $payload['data'] = $data;
  }

  $_SESSION['flash'] = $payload;

  redirect($url);
}


// Flash error message
function flash_error($url = '/', $message = '', $data = [], $status = 'error')
{
  flash_message($url, $message, $status, $data);
}

// Get error
function has_errors()
{
  if (isset($_SESSION['flash']) && $_SESSION['flash']['status'] == 'error') {

    $flash_message = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash_message;
  } else {
    return false;
  }
}

// Return JSON payload
function send_json($message = 'success', $data = [], $status = 'ok', $http_code = 200, $return = false)
{
  $payload = [
    'status' => $status,
    'message' => $message,
    'data' => $data
  ];

  $json = json_encode(($payload));

  if ($return) {
    return $json;
  } else {
    header('Content-Type: application/json');
    http_response_code($http_code);
    echo $json;
  }
}

// Return JSON error
function json_error($message = 'Internal server error', $http_code = 500, $return = false)
{
  send_json($status = 'error', $message, $http_code, $return);
}

// Echo a variable
function e($var = '')
{
  echo ($var);
}


// Get user object
function user($attr = 'username')
{
  if (isset($_SESSION['user'])) {
    return $_SESSION['user']->$attr;
  } else {

    $default = [
      'name' => 'User',
      'username' => 'User',
      'role' => 'user',
      'id' => '0',
    ];

    return $default[$attr];
  }
}

// Authorization checks
function is_logged_in($else_kick_out = false)
{

  if (
    isset($_SESSION['user']) &&
    property_exists($_SESSION['user'], 'username') &&
    property_exists($_SESSION['user'], 'id') &&
    property_exists($_SESSION['user'], 'role')
  ) {
    return true;
  } else {

    if ($else_kick_out) {
      session_destroy();
      redirect();
    }

    return false;
  }
}

function is_admin()
{

  if (is_logged_in()) {
    return $_SESSION['user']->role == 'admin';
  }
}

// Helps validate $_POST input
function validate($input, $validation_obj)
{

  // No input, why use the function?
  if (!isset($input) || !isset($validation_obj)) {
    return false;
  }

  // Holder
  $valid = true;

  foreach ($validation_obj as $name => $key) {

    // Skip loop if already invalid
    if (!$valid) {
      return false;
    }

    switch ($key) {

      case 'required':
        $valid = isset($input[$name]);
        break;
    }
  }


  // If all tests pass, then true
  return true;
}
