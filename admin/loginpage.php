<?php
session_start();

$erre = $errp = '';

if(isset($_POST['submit'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    
    if(!$conn) {
        $errp = "Database not connected";
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erre = "Invalid email format";
    } else {
        $sql = "SELECT * FROM admin WHERE email=? AND password=?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            
            if(is_array($row)) {
                $_SESSION['email'] = $row['email'];
                header('location: homepage.php');
                exit();
            } else {
                $errp = "Invalid username or password";
            }
        } else {
            $errp = "SQL error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="loginpage.css">
</head>
<body>
    <h2>Admin Login</h2>
    <?php if(!empty($errp)) echo "<p>$errp</p>"; ?>
    <?php if(!empty($erre)) echo "<p>$erre</p>"; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>
