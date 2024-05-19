<?php
session_start();

$errp = $erre = '';

if (isset($_POST['submit'])) {
    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    if (!$conn) {
        die("Database not connected: " . mysqli_connect_error());
    }

    // Retrieve form data and sanitize
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM customers WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($password, $row['password'])) {
            // Authentication successful
            echo $row['customer_id'];
            $_SESSION['email'] = $email;
            $_SESSION['customer_id'] = $row['customer_id'];
            header('Location: homepage.php');
            exit();
        } else {
            $errp = "Invalid username or password";
        }
    } else {
        $errp = "SQL error: " . mysqli_error($conn); // Check for SQL error
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6">Customer Login</h2>
        <?php if (!empty($errp))
            echo "<p class='text-red-500'>$errp</p>"; ?>
        <?php if (!empty($erre))
            echo "<p class='text-red-500'>$erre</p>"; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username:</label>
                <input type="text" id="username" name="email" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password:</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
            <button type="submit" name="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Login</button>
        </form>
        <p class="mt-4 text-sm">Don't have an account? <a href="signup.php" class="text-blue-500">Sign up</a></p>
    </div>
</body>

</html>