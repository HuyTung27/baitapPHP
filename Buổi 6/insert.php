<?php
include 'connect.php';
    // Insert data into table
    $sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES
    ('John', 'Doe', 'john@example.com'),
    ('Jane', 'Smith', 'jane@example.com'),
    ('James', 'Johnson', 'james@example.com'),
    ('Emily', 'Brown', 'emily@example.com'),
    ('Michael', 'Davis', 'michael@example.com')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>