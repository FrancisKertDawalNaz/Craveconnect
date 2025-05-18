<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Restaurant Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#E63946',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="p-4 border-b">
                <h1 class="text-2xl font-bold text-primary">CraveConnect</h1>
                <p class="text-sm text-gray-600">Restaurant Portal</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-4">
                <a href="./restaurant-dashboard.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./restaurant-menu.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-utensils w-6"></i>
                    <span>Menu Management</span>
                </a>
                <a href="./restaurant-orders.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span>Orders</span>
                </a>
                <a href="./restaurant-inventory.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-box w-6"></i>
                    <span>Inventory</span>
                </a>
                <a href="./restaurant-analytics.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-chart-line w-6"></i>
                    <span>Analytics</span>
                </a>
                <a href="./restaurant-promotions.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-gift w-6"></i>
                    <span>Promotions & Loyalty</span>
                </a>
                <a href="./restaurant-feedback.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-comments w-6"></i>
                    <span>Customer Feedback</span>
                </a>
                <a href="./restaurant-profile.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-user w-6"></i>
                    <span>Profile</span>
                </a>
                <a href="restaurant-login.html" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary mt-4">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            Welcome, <?php echo isset($_SESSION['owner_name']) ? htmlspecialchars($_SESSION['owner_name']) : 'Restaurant Owner'; ?>
                        </span>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(isset($_SESSION['owner_name']) ? $_SESSION['owner_name'] : 'Restaurant Owner'); ?>&background=E63946&color=fff" 
                                alt="Profile" 
                                class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary/10 text-primary">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Today's Orders</h3>
                                <p class="text-2xl font-semibold">24</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-dollar-sign text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Today's Revenue</h3>
                                <p class="text-2xl font-semibold">$1,234</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Active Customers</h3>
                                <p class="text-2xl font-semibold">156</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Average Rating</h3>
                                <p class="text-2xl font-semibold">4.8</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-gray-500 text-sm">
                                        <th class="pb-4">Order ID</th>
                                        <th class="pb-4">Customer</th>
                                        <th class="pb-4">Items</th>
                                        <th class="pb-4">Total</th>
                                        <th class="pb-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    <tr class="border-t">
                                        <td class="py-4">#12345</td>
                                        <td>John Doe</td>
                                        <td>3 items</td>
                                        <td>$45.00</td>
                                        <td><span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-sm">Completed</span></td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="py-4">#12344</td>
                                        <td>Jane Smith</td>
                                        <td>2 items</td>
                                        <td>$32.50</td>
                                        <td><span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm">Preparing</span></td>
                                    </tr>
                                    <tr class="border-t">
                                        <td class="py-4">#12343</td>
                                        <td>Mike Johnson</td>
                                        <td>4 items</td>
                                        <td>$67.00</td>
                                        <td><span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">Delivering</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Items -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Top Selling Items</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/40" alt="Food item" class="w-10 h-10 rounded-lg">
                                    <div class="ml-4">
                                        <h4 class="text-gray-800">Margherita Pizza</h4>
                                        <p class="text-sm text-gray-500">Italian</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-800">$12.99</p>
                                    <p class="text-sm text-gray-500">45 orders today</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/40" alt="Food item" class="w-10 h-10 rounded-lg">
                                    <div class="ml-4">
                                        <h4 class="text-gray-800">Chicken Burger</h4>
                                        <p class="text-sm text-gray-500">American</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-800">$8.99</p>
                                    <p class="text-sm text-gray-500">38 orders today</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/40" alt="Food item" class="w-10 h-10 rounded-lg">
                                    <div class="ml-4">
                                        <h4 class="text-gray-800">Pad Thai</h4>
                                        <p class="text-sm text-gray-500">Thai</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-800">$14.99</p>
                                    <p class="text-sm text-gray-500">32 orders today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>