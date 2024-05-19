<?php
// Check if product ID is provided
if(isset($_GET['id'])) {
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    // Check if the connection was successful
    if(!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Retrieve product ID from the URL
    $product_id = $_GET['id'];

    // Prepare and execute SQL statement to delete the product
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect back to the admin dashboard after deletion
    header('Location: ../homepage.php');
    exit();
} else {
    // Redirect back to the admin dashboard if product ID is not provided
    header('Location: ../homepage.php');
    exit();
}
?>
