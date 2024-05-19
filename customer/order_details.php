<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen">
    <?php
        session_start();
    ?>
    <div class="flex">
        <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
            <?php include ("./components/sidebar.php"); ?>
        </div>
        <div class="ml-64 p-6">
            <h2 class="text-2xl font-bold mb-4">My Orders</h2>
            
            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-800">
                    <thead>
                        <tr class="bg-gray-800 text-gray-100">
                            <th class="px-4 py-2">Order ID</th>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Quantity</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody class="bg-gray-200">
                        <?php
                        // Connect to the database
                        $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

                        // Check if the connection was successful
                        if (!$conn) {
                            die("Database connection failed: " . mysqli_connect_error());
                        }

                        // Retrieve customer ID from session
                        $customer_id = $_SESSION['customer_id']; // Assuming you have stored the customer ID in a session
                        

                        // Prepare and execute SQL statement to fetch orders for the logged-in user
                        $sql = "SELECT o.id AS order_id, p.name AS product_name, o.quantity 
                                FROM order_details o 
                                JOIN products p ON o.product_id = p.id 
                                WHERE o.customer_id = ?";
                                
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $customer_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        // Check if there are orders
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['order_id'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['product_name'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['quantity'] . "</td>";
                                // Add more columns as needed
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center py-4'>No orders found</td></tr>";
                        }

                        // Close connection
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>