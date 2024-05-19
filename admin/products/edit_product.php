<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">
    <?php
    // Initialize error messages
    $errors = [];

    // Check if the form is submitted
    if (isset($_POST["submit"])) {
        // Retrieve form data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price']; // Convert to float
        $quantity = $_POST['quantity']; // Convert to integer

        // Validation for name
        if (empty($name)) {
            $errors['name'] = "Product name is required.";
        }

        // Validation for price
        if ($price <= 0) {
            $errors['price'] = "Price must be greater than zero.";
        }

        // Validation for quantity
        if ($quantity <= 0) {
            $errors['quantity'] = "Quantity must be greater than zero.";
        }

        // echo $price;
      
        // If no errors, proceed with updating the product
        if (empty($errors)) {
            // Connect to the database
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

            // Check if the connection was successful
            if (!$conn) {
                die("Database connection failed: " . mysqli_connect_error());
            }

            // Retrieve product ID from the form
            $product_id = $_POST['product_id'];

            // Fetch product details from the database
            $sql = "SELECT * FROM products WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            // Close statement
            mysqli_stmt_close($stmt);

            // If product found, display the edit form
            if ($row) {
                // Image handling
                $image = $_FILES['image']['name']; // Get the name of the image file
                $temp_name = $_FILES['image']['tmp_name']; // Get the temporary file name

                // Move uploaded image to desired directory
                $target_dir = "uploads/"; // Specify the directory where images will be stored
                $target_file = $target_dir . basename($image); // Specify the path of the uploaded file

                // Check if image file is a valid image
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $extensions_arr = array("jpg", "jpeg", "png", "gif");

                if (!in_array($imageFileType, $extensions_arr)) {
                    $errors['image'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
                }

                // Update product details in the database
                $update_sql = "UPDATE products SET name=?, description=?, price=?, quantity=?, image=? WHERE id=?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ssdisi", $name, $description, $price, $quantity, $image, $product_id);

                // Execute the update statement
                if (mysqli_stmt_execute($update_stmt)) {
                    // Image uploaded successfully
                    move_uploaded_file($temp_name, $target_file);
                    header('Location: ../homepage.php');
                    exit();
                    // echo "Product updated successfully.";
                } else {
                    echo "Error updating product: " . mysqli_error($conn);
                }

                // Close statement and connection
                mysqli_stmt_close($update_stmt);
                mysqli_close($conn);
            } else {
                // Display error message if product not found
                echo "<p class='text-red-500'>Product not found</p>";
            }
        }
    }
    ?>

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
        <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
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

                // Close statement
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                // If product found, display the edit form
                if ($row) {
                    ?>
                    <form action="" method="post" enctype="multipart/form-data" class="max-w-lg">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                            <!-- Display error message for name -->
                            <?php if (isset($errors['name'])): ?>
                                <label class="text-red-500"><?php echo $errors['name']; ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description:</label>
                            <textarea id="description" name="description"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                rows="4" required><?php echo $row['description']; ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Price:</label>
                            <input type="text" id="price" name="price" min="1" value="<?php echo $row['price']; ?>"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                            <!-- Display error message for price -->
                            <?php if (isset($errors['price'])): ?>
                                <label class="text-red-500"><?php echo $errors['price']; ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="<?php echo $row['quantity']; ?>"
                                oninput="this.value = Math.abs(this.value)"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                            <!-- Display error message for quantity -->
                            <?php if (isset($errors['quantity'])): ?>
                                <label class="text-red-500"><?php echo $errors['quantity']; ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Image:</label>
                            <input type="file" id="image" name="image"
                                class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <!-- Display error message for image -->
                            <?php if (isset($errors['image'])): ?>
                                <label class="text-red-500"><?php echo $errors['image']; ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="mt-6">
                            <button type="submit" name="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update
                                Product</button>
                        </div>
                    </form>
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
    </div>
</body>

</html>
