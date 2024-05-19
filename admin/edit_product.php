<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">
    <!-- Sidebar (Include sidebar.php here if you're using it) -->
    <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
        <!-- Logo -->
        <div class="py-4 px-6">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        </div>
        
        <!-- Navigation Links -->
        <nav>
            <a href="homepage.php" class="block py-2 px-4 text-lg hover:bg-gray-700">Dashboard</a>
            <a href="addproduct.php" class="block py-2 px-4 text-lg hover:bg-gray-700">Add Product</a>
            <a href="#" class="block py-2 px-4 text-lg hover:bg-gray-700">Orders</a>
            <a href="#" class="block py-2 px-4 text-lg hover:bg-gray-700">Customers</a>
            <a href="#" class="block py-2 px-4 text-lg hover:bg-gray-700">Settings</a>
        </nav>
        
        <!-- Footer -->
        <div class="p-2 bg-red-600 rounded-lg">
            <a href="#" class="block text-lg">Logout</a>
        </div>
    </div>

    <!-- Page Content -->
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Product</h2>

        <!-- Edit Product Form -->
        <?php
        // Check if product ID is provided
        if (isset($_GET['id'])) {
            // Connect to the database
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

            // Check if the connection was successful
            if (!$conn) {
                die("Database connection failed: " . mysqli_connect_error());
            }

            // Retrieve product ID from the URL
            $product_id = $_GET['id'];

            // Fetch product details from the database
            $sql = "SELECT * FROM products WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            // Close statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // If product found, display the edit form
            if ($row) {
                ?>
                <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
                    <form action="update_product.php" method="post" enctype="multipart/form-data" class="max-w-lg">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"
                                class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description:</label>
                            <textarea id="description" name="description"
                                class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                rows="4" required><?php echo $row['description']; ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Price:</label>
                            <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>"
                                class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>"
                                class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Image:</label>
                            <input type="file" id="image" name="image"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="mt-6">
                            <button type="submit" name="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Updateee
                                Product</button>
                        </div>
                    </form>
                </div>
                <?php
            } else {
                // Display error message if product not found
                echo "<p class='text-red-500'>Product not found</p>";
            }
        } else {
            // Display error message if product ID is not provided
            echo "<p class='text-red-500'>Product ID not provided</p>";
        }
        ?>
    </div>
</body>

</html>