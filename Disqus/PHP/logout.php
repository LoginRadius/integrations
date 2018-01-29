<?php

// Start session if needed
if (!session_id()) {
    session_start();
}

// Unset user
unset($_SESSION['message']);
unset($_SESSION['timestamp']);
unset($_SESSION['hmac']);

// Redirect
header('Location: index.php');
exit();
