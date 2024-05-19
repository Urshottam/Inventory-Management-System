<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">
    <!-- Sidebar (Include sidebar.php here if you're using it) -->
    <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
        <?php include ("./components/sidebar.php"); ?>
    </div>
    <!-- Page Content -->
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-4">Product Details</h2>
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-800">
                <thead>
                    <tr class="bg-gray-800 text-gray-100">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-200">
                    <!-- Loop through each product and display its details -->
                    <?php
                    // Connect to database and fetch product details
                    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are products
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Determine status based on quantity for each product
                            $status = ($row['quantity'] < 100) ? "Low Quantity" : "Sufficient Quantity";

                            // Output table row
                            echo "<tr>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['id'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['name'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['description'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['price'] . "</td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>" . $row['quantity'] . "</td>";
                            if($row['quantity']<100){
                                echo "<td class='px-4 py-2 border border-gray-600 text-red-500'>" . "Less products are there" . "</td>"; // Display status
                            }
                            else{
                                echo "<td class='px-4 py-2 border border-gray-600 text-green-600'>" . "Sufficient Quantity" . "</td>"; // Display status
                            }
                            // echo "<td class='px-4 py-2 border border-gray-600'>" .  . "</td>"; // Display status
                            echo "<td class='px-4 py-2 border border-gray-600'><img src='uploads/" . $row['image'] . "' class='h-10 w-10 object-cover'></td>";
                            echo "<td class='px-4 py-2 border border-gray-600'>
                <a href='products/edit_product.php?id=" . $row['id'] . "' class='text-blue-600 hover:text-blue-900 mr-2'>Edit</a>
                <a href='products/delete_product.php?id=" . $row['id'] . "' class='text-red-600 hover:text-red-900'>Delete</a>
            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4'>No products found</td></tr>";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>