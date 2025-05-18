<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Promotions & Loyalty</title>
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
                    <h2 class="text-xl font-semibold text-gray-800">Promotions & Loyalty</h2>
                    <div class="flex items-center space-x-4">
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Create Promotion
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Active Promotions</p>
                                <h3 class="text-2xl font-semibold text-gray-800">5</h3>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-tag text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Loyalty Members</p>
                                <h3 class="text-2xl font-semibold text-gray-800">1,234</h3>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-users text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Points Redeemed</p>
                                <h3 class="text-2xl font-semibold text-gray-800">8,560</h3>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-coins text-purple-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Discounts</p>
                                <h3 class="text-2xl font-semibold text-gray-800">$2,450</h3>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-percentage text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Promotions -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Active Promotions</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Promotion 1 -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-red-100 rounded-full">
                                        <i class="fas fa-percentage text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Weekend Special</h4>
                                        <p class="text-sm text-gray-500">20% off on all pizzas</p>
                                        <p class="text-xs text-gray-400">Valid until March 31, 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Promotion 2 -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-blue-100 rounded-full">
                                        <i class="fas fa-gift text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Buy 1 Get 1 Free</h4>
                                        <p class="text-sm text-gray-500">On selected desserts</p>
                                        <p class="text-xs text-gray-400">Valid until April 15, 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loyalty Program -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Loyalty Rules -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Loyalty Program Rules</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Points Earning</h4>
                                        <p class="text-sm text-gray-500">1 point per $1 spent</p>
                                    </div>
                                    <button class="text-primary hover:text-primary/80">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Points Redemption</h4>
                                        <p class="text-sm text-gray-500">100 points = $5 discount</p>
                                    </div>
                                    <button class="text-primary hover:text-primary/80">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Tier Benefits</h4>
                                        <p class="text-sm text-gray-500">Silver: 500 points, Gold: 1000 points</p>
                                    </div>
                                    <button class="text-primary hover:text-primary/80">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loyalty Members -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Top Loyalty Members</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Member 1 -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=E63946&color=fff" 
                                            alt="John Doe" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">John Doe</h4>
                                            <p class="text-sm text-gray-500">Gold Member</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">1,250 points</p>
                                        <p class="text-xs text-gray-500">$1,250 spent</p>
                                    </div>
                                </div>

                                <!-- Member 2 -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=E63946&color=fff" 
                                            alt="Jane Smith" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Jane Smith</h4>
                                            <p class="text-sm text-gray-500">Silver Member</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">850 points</p>
                                        <p class="text-xs text-gray-500">$850 spent</p>
                                    </div>
                                </div>

                                <!-- Member 3 -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=E63946&color=fff" 
                                            alt="Mike Johnson" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Mike Johnson</h4>
                                            <p class="text-sm text-gray-500">Silver Member</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">720 points</p>
                                        <p class="text-xs text-gray-500">$720 spent</p>
                                    </div>
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