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

    // File upload handling
    $target_dir = "uploads/"; // Specify the directory where the file will be stored
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file was uploaded
    if ($_FILES["image"]["size"] > 0) {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare and execute SQL statement to update the product including the image
            $sql = "UPDATE products SET name=?, description=?, price=?, quantity=?, image=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdiis", $name, $description, $price, $quantity, $target_file, $product_id);
        } else {
            // Error uploading file
            echo "Error uploading file";
            exit();
        }
    } else {
        // Prepare and execute SQL statement to update the product without changing the image
        $sql = "UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdii", $name, $description, $price, $quantity, $product_id);
    }

    // Execute the statement
    if(mysqli_stmt_execute($stmt)) {
        // Product updated successfully
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: homepage.php');
        exit();
    } else {
        // Error updating product
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo "Error updating product";
    }
} else {
    // Redirect or show an error if form is not submitted
    header('Location: homepage.php');
    exit();
}
?>
