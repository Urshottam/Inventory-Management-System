<?php
// Check if form is submitted
if(isset($_POST['submit'])) {
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    // Check if the connection was successful
    if(!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Retrieve form data
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Prepare and execute SQL statement to update the product
    $sql = "UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdii", $name, $description, $price, $quantity, $product_id);

    // Execute the statement
    if(mysqli_stmt_execute($stmt)) {
        // Product updated successfully
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: admin_dashboard.php');
        exit();
    } else {
        // Error updating product
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo "Error updating product";
    }
} else {
    // Redirect or show an error if form is not submitted
    header('Location: admin_dashboard.php');
    exit();
}
?>
