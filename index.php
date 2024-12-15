<?php
// Connect to database
$connection = new mysqli("localhost", "root", "", "ecommerce");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Our E-Commerce Site</h1>

    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['description'] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</body>
</html>

<?php
// Close connection
$connection->close();
?>
