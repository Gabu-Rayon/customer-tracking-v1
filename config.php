<?php
// Database configuration
$host = "localhost";       // Hostname
$dbname = "customer-tracking-db";  // Database name
$username = "Gibson"; // Database username
$password = "Gibson@12345#"; // Database password
$charset = "utf8";          // Character set (optional)

// PDO options
$options = [
    PDO::ATTR_ERRMODE     => PDO::ERRMODE_EXCEPTION, // Enable error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode
    PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulated prepared statements
];

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password, $options);
} catch (PDOException $e) {
    // Handle connection errors
    die("Error: " . $e->getMessage());
}
