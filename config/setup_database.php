<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

require_once __DIR__ . '/database.php';

try {
    error_log("Starting database setup...");
    
    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/database.sql');
    if ($sql === false) {
        throw new Exception("Could not read database.sql file");
    }
    
    // Connect to MySQL without selecting a database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    error_log("Connected to MySQL server");
    
    // Execute the SQL commands
    if ($conn->multi_query($sql)) {
        do {
            // Store first result set
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    }
    
    if ($conn->error) {
        throw new Exception("Error executing SQL: " . $conn->error);
    }
    
    error_log("Database setup completed successfully");
    echo "Database setup completed successfully!";
    
} catch (Exception $e) {
    error_log("Database setup error: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
} 