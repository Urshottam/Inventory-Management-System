//     // Prepare and execute SQL statement to insert the order
        //     $sql = "INSERT INTO orders (product_id, customer_id, quantity) VALUES (?, ?, ?)";
        //     $stmt = mysqli_prepare($conn, $sql);
        //     mysqli_stmt_bind_param($stmt, "iii", $product_id, $customer_id, $quantity);
    
        //     // Execute the statement
        //     if (mysqli_stmt_execute($stmt)) {
        //         // Order placed successfully
        //         mysqli_stmt_close($stmt);
        //         mysqli_close($conn);
        //         header('Location: myloandetails.com');
        //         exit();
        //     } else {
        //         // Error placing order
        //         mysqli_stmt_close($stmt);
        //         mysqli_close($conn);
        //         echo "Error placing order";
        //     }
        // } else {
        //     // Redirect or show an error if form is not submitted
        //     header('Location: homepage.php');
        //     exit();