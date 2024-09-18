<?php
// CORS header settings
header("Access-Control-Allow-Origin: *"); // Allow all domain (használj *-ot, ha nincs Credentials)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allow all HTTP methods
header("Access-Control-Allow-Credentials: true"); // Use only with specific origin, not with *
header("Access-Control-Max-Age: 86400"); // Cache preflight requests for 1 day
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed HTTP types
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}
?>
