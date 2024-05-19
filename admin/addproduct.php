<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<?php
// Initialize error messages
$errors = [];
$success = "";

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    if (!$conn) {
        die("Database not connected: " . mysqli_connect_error());
    }

    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']); // Convert to float
    $quantity = intval($_POST['quantity']); // Convert to integer

    // Validation for name
    if (empty($name)) {
        $errors['name'] = "Product name is required.";
    }

    // Validation for description (optional)

    // Validation for price
    if ($price <= 0) {
        $errors['price'] = "Price must be greater than zero.";
    }

    // Validation for quantity
    if ($quantity <= 0) {
        $errors['quantity'] = "Quantity must be greater than zero.";
    }

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

    // If no errors, insert data into database
    if (empty($errors)) {
        // Insert data into products table
        $sql = "INSERT INTO products (name, description, price, quantity, image) VALUES ('$name', '$description', '$price', '$quantity', '$image')";

        if (mysqli_query($conn, $sql)) {
            // Image uploaded successfully
            move_uploaded_file($temp_name, $target_file);
            $success = "Product added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<div class="flex gap-20">
    <div>
        <?php include("./components/sidebar.php"); ?>
    </div>
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">Add Product</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-gray-900">Product Name:</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <!-- Display error message for name -->
                <?php if(isset($errors['name'])): ?>
                    <label class="text-red-500"><?php echo $errors['name']; ?></label>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-900">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                <!-- Validation for description is optional -->
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-900">Price:</label>
                <input type="text" id="price" name="price" required
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <!-- Display error message for price -->
                <?php if(isset($errors['price'])): ?>
                    <label class="text-red-500"><?php echo $errors['price']; ?></label>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-900">Quantity:</label>
                <input type="text" id="quantity" name="quantity" required
                    class="mt-1 p-2 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <!-- Display error message for quantity -->
                <?php if(isset($errors['quantity'])): ?>
                    <label class="text-red-500"><?php echo $errors['quantity']; ?></label>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-900">Image:</label>
                <input type="file" id="image" name="image"
                    class="mt-1 block w-full rounded-md bg-gray-100 border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <!-- Display error message for image -->
                <?php if(isset($errors['image'])): ?>
                    <label class="text-red-500"><?php echo $errors['image']; ?></label>
                <?php endif; ?>
            </div>
            <button type="submit" name="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600 w-full">Submit</button>
            <label for="" class="text-red-500"><?php echo $success; ?></label>

        </form>
    </div>
</div>

</body>

</html>