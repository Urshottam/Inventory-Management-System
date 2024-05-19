<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page or display an error message
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar (Include sidebar.php here if you're using it) -->
    <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
        <?php include ("./components/sidebar.php"); ?>
    </div>

    <!-- Page Content -->
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-4">Available Products</h2>
        

        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Connect to database and fetch product details
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            // Check if there are products
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $row['image']; ?>
                    
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <img src="../admin/uploads/<?php echo $row['image']; ?>" alt="" 
                        
                            class="w-full h-40 object-cover mb-4">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="text-xl font-semibold mb-2">
                                    <?php echo $row['name']; ?>
                                </h3>
                                <p class="text-gray-600 mb-2">
                                    <?php echo $row['description']; ?>
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500 font-bold">$
                                    <?php echo $row['price']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <!-- Form for ordering a product -->
                            <form action="place_order.php?product_id=<?php echo $row['id']; ?>&price=<?php echo $row['price']; ?>" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['customer_id']; ?>">
                                <!-- Assuming you have stored the user ID in a session -->
                                <button type="submit" name="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Order Now</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No products found</p>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>
