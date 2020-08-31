<?php

require_once '../init.php';

// Check if data is sent
if (isset($_GET['id'])) {
  // For future user tracking
  session_destroy();
  redirect('/');
} else {
  session_destroy();
  redirect('/');
}
exit();
