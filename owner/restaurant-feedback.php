<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Customer Feedback</title>
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
                    <h2 class="text-xl font-semibold text-gray-800">Customer Feedback</h2>
                    <div class="flex items-center space-x-4">
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>All Time</option>
                            <option>Last 30 Days</option>
                            <option>Last 7 Days</option>
                            <option>Today</option>
                        </select>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Export Feedback
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
                                <p class="text-sm text-gray-500">Average Rating</p>
                                <h3 class="text-2xl font-semibold text-gray-800">4.5</h3>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-star text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Reviews</p>
                                <h3 class="text-2xl font-semibold text-gray-800">1,234</h3>
                                <p class="text-sm text-green-600">+12% from last month</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-comments text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Response Rate</p>
                                <h3 class="text-2xl font-semibold text-gray-800">98%</h3>
                                <p class="text-sm text-green-600">+5% from last month</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-reply text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Pending Responses</p>
                                <h3 class="text-2xl font-semibold text-gray-800">3</h3>
                                <p class="text-sm text-red-600">Requires attention</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Distribution -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Rating Distribution</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- 5 Stars -->
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600">5 Stars</div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 75%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right">750</div>
                            </div>
                            <!-- 4 Stars -->
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600">4 Stars</div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 15%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right">150</div>
                            </div>
                            <!-- 3 Stars -->
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600">3 Stars</div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 5%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right">50</div>
                            </div>
                            <!-- 2 Stars -->
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600">2 Stars</div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 3%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right">30</div>
                            </div>
                            <!-- 1 Star -->
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600">1 Star</div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: 2%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right">20</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Reviews</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Review 1 -->
                            <div class="border-b pb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Wilson&background=E63946&color=fff" 
                                            alt="Sarah Wilson" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Sarah Wilson</h4>
                                            <p class="text-xs text-gray-500">March 15, 2024</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">
                                    "The food was absolutely amazing! The service was quick and the staff was very friendly. 
                                    I especially loved the Margherita pizza and the tiramisu for dessert. Will definitely come back!"
                                </p>
                                <div class="flex items-center space-x-4">
                                    <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                        <i class="fas fa-reply mr-1"></i>
                                        Reply
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                        <i class="fas fa-flag mr-1"></i>
                                        Flag
                                    </button>
                                </div>
                            </div>

                            <!-- Review 2 -->
                            <div class="border-b pb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=E63946&color=fff" 
                                            alt="Michael Brown" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Michael Brown</h4>
                                            <p class="text-xs text-gray-500">March 14, 2024</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">
                                    "Great food and atmosphere. The only reason for 4 stars is that the wait time was a bit longer than expected. 
                                    Otherwise, everything was perfect!"
                                </p>
                                <div class="flex items-center space-x-4">
                                    <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                        <i class="fas fa-reply mr-1"></i>
                                        Reply
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                        <i class="fas fa-flag mr-1"></i>
                                        Flag
                                    </button>
                                </div>
                            </div>

                            <!-- Review 3 -->
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=Emily+Davis&background=E63946&color=fff" 
                                            alt="Emily Davis" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Emily Davis</h4>
                                            <p class="text-xs text-gray-500">March 13, 2024</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">
                                    "The pasta dishes are incredible! The portion sizes are generous and the flavors are amazing. 
                                    The staff was attentive and the ambiance was perfect for a date night."
                                </p>
                                <div class="flex items-center space-x-4">
                                    <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                        <i class="fas fa-reply mr-1"></i>
                                        Reply
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                        <i class="fas fa-flag mr-1"></i>
                                        Flag
                                    </button>
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