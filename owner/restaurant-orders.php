<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Orders Management</title>
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
                    <h2 class="text-xl font-semibold text-gray-800">Orders Management</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search orders..." 
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                    </div>
                </div>
            </header>

            <!-- Orders Content -->
            <main class="p-6">
                <!-- Order Status Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-4 border-b">
                        <button class="px-4 py-2 text-primary border-b-2 border-primary font-medium">New Orders</button>
                        <button class="px-4 py-2 text-gray-600 hover:text-primary">Preparing</button>
                        <button class="px-4 py-2 text-gray-600 hover:text-primary">Ready for Pickup</button>
                        <button class="px-4 py-2 text-gray-600 hover:text-primary">Completed</button>
                        <button class="px-4 py-2 text-gray-600 hover:text-primary">Cancelled</button>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-4">
                    <!-- Order Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Order #12345</h3>
                                    <p class="text-sm text-gray-500">March 15, 2024 - 12:30 PM</p>
                                </div>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm font-medium">New</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Customer:</span>
                                            <span class="font-medium">John Doe</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Items:</span>
                                            <span class="font-medium">3 items</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Total:</span>
                                            <span class="font-medium text-primary">$45.99</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Order Type:</span>
                                            <span class="font-medium">Delivery</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Payment:</span>
                                            <span class="font-medium">Credit Card</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Estimated Time:</span>
                                            <span class="font-medium">25-30 mins</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end space-x-3">
                                <button class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg border">
                                    View Details
                                </button>
                                <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                                    Accept Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Order #12344</h3>
                                    <p class="text-sm text-gray-500">March 15, 2024 - 12:15 PM</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium">Preparing</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Customer:</span>
                                            <span class="font-medium">Jane Smith</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Items:</span>
                                            <span class="font-medium">2 items</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Total:</span>
                                            <span class="font-medium text-primary">$32.50</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Order Type:</span>
                                            <span class="font-medium">Pickup</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Payment:</span>
                                            <span class="font-medium">Cash</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Estimated Time:</span>
                                            <span class="font-medium">15-20 mins</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end space-x-3">
                                <button class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg border">
                                    View Details
                                </button>
                                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                    Mark as Ready
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 rounded-lg bg-primary text-white">1</button>
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 