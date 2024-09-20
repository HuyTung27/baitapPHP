<?php
    include 'connect.php';

    // Create database (if not exists)
    $sql = "CREATE DATABASE IF NOT EXISTS b5_mydb";
    if (mysqli_query($conn, $sql)) {
        echo "Database created successfully or already exists.";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }

    // Select the newly created database
    mysqli_select_db($conn, 'b5_mydb');

    // SQL to create table
    $sql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table MyGuests created successfully or already exists.";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    // Insert data into table
    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
    VALUES ('John', 'Doe', 'john@example.com')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
