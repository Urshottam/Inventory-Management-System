<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - All Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex">
        <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
            <?php include ("./components/sidebar.php"); ?>
        </div>
        <!-- Page Content -->
        <div class="ml-64 p-6">
            <h2 class="text-2xl font-bold mb-4">All Orders</h2>

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-800">
                    <thead>
                        <tr class="bg-gray-800 text-gray-100">
                            <th class="px-4 py-2">Order ID</th>
                            <th class="px-4 py-2">Customer Name</th>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Order Date</th>
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

                        // Prepare and execute SQL statement to fetch all orders
                        $sql = "SELECT o.id AS order_id, o.order_date AS order_date, c.full_name AS customer_name, p.name AS product_name, o.quantity 
                        FROM order_details o 
                        JOIN customers c ON o.customer_id = c.customer_id 
                        JOIN products p ON o.product_id = p.id
                        ";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are orders
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['order_id'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['customer_name'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['product_name'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['quantity'] . "</td>";
                                echo "<td class='px-4 py-2 border border-gray-600'>" . $row['order_date'] . "</td>";
                                // Add more columns as needed
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center py-4'>No orders found</td></tr>";
                        }
                        
                        // Close connection
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>