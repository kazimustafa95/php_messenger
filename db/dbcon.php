<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'chat_app';

    // Connect to the database
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>