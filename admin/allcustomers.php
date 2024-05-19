<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - All Customers</title>
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
        <h2 class="text-2xl font-bold mb-4">All Customers</h2>
        <!-- Customers Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-800">
                <thead>
                    <tr class="bg-gray-800 text-gray-100">
                        <th class="px-4 py-2">Customer ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
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

                    // Prepare and execute SQL statement to fetch all customers
                    $sql = "SELECT * FROM customers";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are customers
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['customer_id'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['full_name'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['email'] . "</td>";
                            // Add more columns as needed
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center py-4'>No customers found</td></tr>";
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