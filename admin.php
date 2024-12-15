<?php
// Admin login (Basic check)
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Connect to database
    $connection = new mysqli("localhost", "root", "", "ecommerce");

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Move image to the uploads folder
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Insert data into the database
        $sql = "INSERT INTO products (name, description, image) VALUES ('$name', '$description', '$image')";
        if ($connection->query($sql) === TRUE) {
            echo "New product added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        echo "Failed to upload image.";
    }

    // Close connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Panel</h1>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="description">Product Description:</label>
        <textarea name="description" id="description" required></textarea><br><br>
        
        <label for="image">Product Image:</label>
        <input type="file" name="image" id="image" required><br><br>
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
