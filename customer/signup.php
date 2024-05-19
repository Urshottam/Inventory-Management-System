<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <?php
    session_start();

    $erru = $erre = $errp = '';

    if (isset($_POST['submit'])) {
       
        // Establish database connection
        $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

        if (!$conn) {
            die("Database not connected: " . mysqli_connect_error());
        }

        // Retrieve form data
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];

        var_dump($fullname, $email, $password, $mobile);

        // Validate and sanitize data
        if (strlen($mobile) != 10 || !ctype_digit($mobile)) {
            $erru = "Mobile number should be exactly 10 digits long";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute SQL statement to insert data into the database
            // Prepare and execute SQL statement to insert data into the database
            $sql = "INSERT INTO customers (full_name, email, password, mobile) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $hashed_password, $mobile);
                if (mysqli_stmt_execute($stmt)) {
                    // Data inserted successfully
                    header('Location: login.php');
                    exit();
                } else {
                    $errp = "Failed to insert data";
                }
            } else {
                $errp = "SQL error: " . mysqli_error($conn); // Check for SQL error
            }


            // Close statement and connection
            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);
    }
    ?>


    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h1 class="text-3xl text-center font-semibold mb-6">Sign Up</h1>
        <form action="" method="post" class="grid grid-cols-1 gap-4">
            <div>
                <label for="fullname" class="block text-gray-600 mb-2">Name</label>
                <input type="text" id="fullname" name="fullname"
                    class="w-full px-4 py-2 text-lg text-gray-800 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                    placeholder="Enter your name" required>
                <span class="text-red-500">
                    <?php echo $erru; ?>
                </span>
            </div>
            <div>
                <label for="email" class="block text-gray-600 mb-2">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 text-lg text-gray-800 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                    placeholder="Enter your email" required>
                <span class="text-red-500">
                    <?php echo $erre; ?>
                </span>
            </div>
            <div class="">
                <div>
                    <label for="password" class="block text-gray-600 mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 text-lg text-gray-800 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                        placeholder="Enter your password" required>
                    <span class="text-red-500">
                        <?php echo $errp; ?>
                    </span>
                </div>
            </div>
            <div>
                <label for="mobile" class="block text-gray-600 mb-2">Mobile Number</label>
                <input type="text" id="mobile" name="mobile"
                    class="w-full px-4 py-2 text-lg text-gray-800 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500"
                    placeholder="Enter your mobile number" required>
                <span class="text-red-500">
                    <?php echo $erru; ?>
                </span>
            </div>
            <button type="submit" name="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-300">Sign
                Up</button>
            <p class="mt-4 text-center text-gray-600">Already have an account? <a href="login.php"
                    class="text-blue-500">Login here</a></p>
        </form>
    </div>

</body>

</html>