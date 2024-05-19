<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-gray-100 flex flex-col justify-between h-screen w-64">
        <!-- Logo -->
        <div class="py-4 px-6">
            <h1 class="text-xl font-bold">Customer Dashboard</h1>
        </div>
        
        <!-- Navigation Links -->
        <nav>
            <a href="homepage.php" class="block py-2 px-4 text-lg hover:bg-gray-700">All Products</a>
            <a href="order_details.php" class="block py-2 px-4 text-lg hover:bg-gray-700">My Orders</a>
        </nav>
        
        <!-- Footer -->
        <div class="p-2 bg-red-600 rounded-lg">
            <a href="logout.php" class="block text-lg">Logout</a>
        </div>
    </div>
</body>
</html>
