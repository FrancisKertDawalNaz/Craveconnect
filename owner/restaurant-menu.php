<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Menu Management</title>
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
                    <h2 class="text-xl font-semibold text-gray-800">Menu Management</h2>
                    <button onclick="openModal()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Item
                    </button>
                </div>
            </header>            
            <main class="p-6">
                <!-- Categories -->
                <div class="mb-6">
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        <button class="px-4 py-2 bg-primary text-white rounded-lg">All Items</button>
                        <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50">Appetizers</button>
                        <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50">Main Course</button>
                        <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50">Desserts</button>
                        <button class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50">Beverages</button>
                    </div>
                </div>

                <!-- Menu Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Menu Item Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                alt="Margherita Pizza" 
                                class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute top-2 right-2 flex space-x-2">
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-edit text-gray-600"></i>
                                </button>
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-trash text-red-500"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Margherita Pizza</h3>
                                    <p class="text-sm text-gray-500">Italian</p>
                                </div>
                                <span class="text-lg font-semibold text-primary">$12.99</span>
                            </div>
                            <p class="mt-2 text-gray-600 text-sm">Fresh tomatoes, mozzarella, basil, and olive oil</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-sm">Available</span>
                                <button class="text-primary hover:text-primary/80">
                                    <i class="fas fa-eye"></i> Preview
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                alt="Chicken Burger" 
                                class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute top-2 right-2 flex space-x-2">
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-edit text-gray-600"></i>
                                </button>
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-trash text-red-500"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Chicken Burger</h3>
                                    <p class="text-sm text-gray-500">American</p>
                                </div>
                                <span class="text-lg font-semibold text-primary">$8.99</span>
                            </div>
                            <p class="mt-2 text-gray-600 text-sm">Grilled chicken patty with lettuce, tomato, and special sauce</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-sm">Available</span>
                                <button class="text-primary hover:text-primary/80">
                                    <i class="fas fa-eye"></i> Preview
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Item Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                                alt="Pad Thai" 
                                class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute top-2 right-2 flex space-x-2">
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-edit text-gray-600"></i>
                                </button>
                                <button class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                    <i class="fas fa-trash text-red-500"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Pad Thai</h3>
                                    <p class="text-sm text-gray-500">Thai</p>
                                </div>
                                <span class="text-lg font-semibold text-primary">$14.99</span>
                            </div>
                            <p class="mt-2 text-gray-600 text-sm">Stir-fried rice noodles with tofu, shrimp, peanuts, and tamarind sauce</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm">Low Stock</span>
                                <button class="text-primary hover:text-primary/80">
                                    <i class="fas fa-eye"></i> Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add New Item Modal -->
    <div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Add New Menu Item</h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto">
                <form class="space-y-6" method="POST" enctype="multipart/form-data" action="./auth/insert_menu.php">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                            <input type="text" name="item_name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Enter item name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Select category</option>
                                <option value="appetizers">Appetizers</option>
                                <option value="main">Main Course</option>
                                <option value="desserts">Desserts</option>
                                <option value="beverages">Beverages</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                            <div class="relative">
                                <span class="absolute left-4 top-2 text-gray-500">$</span>
                                <input type="number" step="0.01" name="price" required
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                rows="3"
                                placeholder="Enter item description"></textarea>
                        </div>
                    </div>

                    <!-- Image Upload (not handled in PHP for now) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Item Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary/80">
                                        <span>Upload a file</span>
                                        <input type="file" class="sr-only" accept="image/*" name="image">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="isAvailable" name="is_available" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="isAvailable" class="ml-2 block text-sm text-gray-700">Item is available</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="isSpicy" name="is_spicy" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="isSpicy" class="ml-2 block text-sm text-gray-700">Mark as spicy</label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg mr-2">
                            Cancel
                        </button>
                        <button type="submit" name="add_menu_item" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                            Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addItemModal').classList.remove('hidden');
            document.getElementById('addItemModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('addItemModal').classList.add('hidden');
            document.getElementById('addItemModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('addItemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>