<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen">
    <?php
    session_start();
    // Assuming you have stored the product price in $product_price variable
    $product_price = $_GET['price']; // Example value, replace it with your actual product price
    if (isset($_POST['submitt'])) {
        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

        // Check if the connection was successful
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Retrieve form data
        $customer_id = $_SESSION['customer_id']; // Assuming you have stored the customer ID in a session
        $product_id = $_GET['product_id']; // Assuming product_id is passed in the URL
        $_SESSION['product_id'] = $_GET['product_id'];
        $quantity = $_POST['quantity'];
        $_SESSION['quantity'] = $quantity;

        echo "The quantity from the session is: ".$_SESSION['quantity'];

        $encoded_quantity = urlencode($quantity);

        // Validate quantity
        if ($quantity <= 0 || $quantity > 10000) {
            echo '<script>alert("Quantity must be a positive number and less than or equal to 10000.");</script>';
        } else {
            // Check if an order for the same product by the same customer already exists
            $check_query = "SELECT * FROM orders WHERE customer_id = $customer_id AND product_id = $product_id";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // If order exists, update the quantity
                $row = mysqli_fetch_assoc($check_result);
                $existing_quantity = $row['quantity'];
                $new_quantity = $existing_quantity + $quantity;

                // Update the existing order with the new quantity
                $update_query = "UPDATE orders SET quantity = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
                if (mysqli_query($conn, $update_query)) {
                    // echo "Quantity updated successfully!";
                    // location("");
                    // header("Location: booking/esewa.php?quantity=$encoded_quantity");

                    header("Location: booking/esewa.php?quantity=$encoded_quantity&price=$product_price");
                } else {
                    echo "Error updating quantity: " . mysqli_error($conn);
                }
            } else {
                // If no order exists, insert a new order
                $insert_query = "INSERT INTO orders (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)";
                if (mysqli_query($conn, $insert_query)) {

                    header("Location: booking/esewa.php?quantity=$encoded_quantity&price=$product_price");
                } else {
                    echo "Error placing order: " . mysqli_error($conn);
                }
            }
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>

    <div class="flex">
        <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
            <?php include ("./components/sidebar.php"); ?>
        </div>
        <div class="max-w-md h-2/3 bg-white p-8 m-12 rounded shadow-md">
            <h2 class="text-2xl fw-full ont-bold mb-6">Place Order</h2>
            <form action="" method="POST" onsubmit="return validateQuantity()">
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700">Quantity:</label>
                    <input type="number" id="quantity" name="quantity"
                        class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        placeholder="Enter quantity" required oninput="calculateTotal()">
                </div>
                <div id="totalPrice"></div> <!-- Placeholder for displaying total price -->
                <input type="submit" name="submitt" value="Order Now"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600" />
            </form>
        </div>
    </div>

    <script>
        function validateQuantity() {
            var quantity = document.getElementById('quantity').value;
            if (quantity <= 0 || quantity > 10000) {
                alert("Quantity must be a positive number and less than or equal to 10000.");
                return false;
            }
            return true;
        }

        function calculateTotal() {
            var quantity = document.getElementById('quantity').value;
            var productPrice = <?php echo $product_price; ?>; // Retrieve product price from PHP variable
            var totalPrice = quantity * productPrice;
            document.getElementById('totalPrice').innerText = "Total Price: $" + totalPrice.toFixed(2);
        }
    </script>
</body>

</html>