<?php
session_start();
include 'components/sidebar.php'; // Assuming you have a navbar component

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'summerProject');

// Check if connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if product ID is set in session
if (isset($_SESSION['product_id'])) {
    // Retrieve product ID from session
    $product_id = $_SESSION['product_id'];

    // Retrieve order information from orders table based on product ID
    $sql = "SELECT * FROM orders WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Fetch order details
        $row = mysqli_fetch_assoc($result);

        // Extract data from fetched row
        $customer_id = $row['customer_id'];
        $order_date = $row['order_date'];
        $quantity = $_SESSION['quantity']; // Assuming the quantity is always 1 for each order

        // Construct INSERT query for order_details table
        $insert_query = "INSERT INTO order_details (product_id, product_name, customer_id, order_date, quantity)
                         VALUES ($product_id, 'Product Name', $customer_id, '$order_date', $quantity)";

        // Execute INSERT query
        if (mysqli_query($conn, $insert_query)) {
            // Order details inserted successfully

            // Update products table to decrement quantity
            $update_query = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
            if (mysqli_query($conn, $update_query)) {
                // Quantity updated successfully

                echo "<div class='container mx-auto mt-8'>
                        <div class='max-w-md mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>
                            <strong class='font-bold'>Booking Successful!</strong>
                            <span class='block sm:inline'>Your booking has been successfully processed. Thank you for your order!</span>
                        </div>
                    </div>";

                // JavaScript code for redirecting after 5 seconds
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'order_details.php';
                        }, 5000);
                    </script>";
            } else {
                // Error updating quantity
                echo "Error updating product quantity: " . mysqli_error($conn);
            }
        } else {
            // Error inserting order details
            echo "Error inserting order details: " . mysqli_error($conn);
        }
    } else {
        // Error with query
        echo "Error fetching order information: " . mysqli_error($conn);
    }
} else {
    // Product ID not set in session
    echo "Product ID not set.";
}

// Close connection
mysqli_close($conn);
?>
