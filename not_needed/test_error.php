<?php
// Enable error reporting for testing
error_reporting(E_ALL);
ini_set('display_errors', 1); // Optional: Set to 1 to display errors in the browser for testing

// Trigger a fatal error
trigger_error("Some info", E_USER_ERROR);
?>
