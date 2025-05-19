<?php
// Database connection
include_once __DIR__ . '/auth/connection.php';

// Fetch inventory items from the database
$inventory_items = [];
$sql = "SELECT * FROM inventory_items ORDER BY last_updated DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $inventory_items[] = $row;
    }
}

// Quick stats calculations
$total_items = count($inventory_items);
$low_stock = 0;
$out_of_stock = 0;
$total_value = 0;
foreach ($inventory_items as $item) {
    if ($item['current_stock'] <= 0) {
        $out_of_stock++;
    } else if ($item['current_stock'] <= $item['min_stock']) {
        $low_stock++;
    }
    $total_value += $item['current_stock'] * $item['unit_cost'];
}

// Pagination logic
$items_per_page = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($page - 1) * $items_per_page;
$paginated_items = array_slice($inventory_items, $start_index, $items_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Inventory Management</title>
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
                    <h2 class="text-xl font-semibold text-gray-800">Inventory Management</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="inventorySearch" placeholder="Search inventory..." 
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button onclick="showAddItemModal()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Item
                        </button>
                    </div>
                </div>
            </header>

            <!-- Inventory Content -->
            <main class="p-6">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Items</p>
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $total_items; ?></h3>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-box text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Low Stock Items</p>
                                <h3 class="text-2xl font-semibold text-yellow-600"><?php echo $low_stock; ?></h3>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Out of Stock</p>
                                <h3 class="text-2xl font-semibold text-red-600"><?php echo $out_of_stock; ?></h3>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-times-circle text-red-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Value</p>
                                <h3 class="text-2xl font-semibold text-gray-800">$<?php echo number_format($total_value, 2); ?></h3>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="mb-6">
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        <button class="px-4 py-2 bg-primary text-white rounded-lg">All Items</button>
                    </div>
                </div>

                <!-- Inventory Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($paginated_items)): ?>
                                <?php foreach ($paginated_items as $item): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="<?php echo !empty($item['image_url']) ? 'uploads/' . htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/100x100?text=No+Image'; ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['item_name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['sku']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($item['category']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900"><?php echo htmlspecialchars($item['current_stock']); ?></div>
                                            <div class="text-xs text-gray-500">Min: <?php echo htmlspecialchars($item['min_stock']); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($item['unit']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                                $status = 'In Stock';
                                                $statusClass = 'bg-green-100 text-green-800';
                                                if ($item['current_stock'] <= 0) {
                                                    $status = 'Out of Stock';
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                } else if ($item['current_stock'] <= $item['min_stock']) {
                                                    $status = 'Low Stock';
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                }
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                                                <?php echo $status; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('M d, Y', strtotime($item['last_updated'])); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button class="text-primary hover:text-primary/80 mr-3">Edit</button>
                                            <button class="text-primary hover:text-primary/80">Restock</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="py-4 text-center text-gray-400">No inventory items found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50" <?php if ($page <= 1) echo 'disabled'; ?> onclick="window.location.href='?page=<?php echo max(1, $page-1); ?>'">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <button class="px-3 py-1 rounded-lg <?php echo $i == $page ? 'bg-primary text-white' : 'border hover:bg-gray-50'; ?>" onclick="window.location.href='?page=<?php echo $i; ?>'">
                                <?php echo $i; ?>
                            </button>
                        <?php endfor; ?>
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50" <?php if ($page >= $total_pages) echo 'disabled'; ?> onclick="window.location.href='?page=<?php echo min($total_pages, $page+1); ?>'">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <!-- Add New Item Modal -->
    <div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-6 border-b flex-shrink-0">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-semibold">Add New Inventory Item</h3>
                    <button onclick="closeAddItemModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto">
                <form class="space-y-6" id="addItemForm" method="POST" action="auth/insert_inventory.php" enctype="multipart/form-data">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">Basic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                                <input type="text" name="item_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                                <input type="text" name="sku" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select Category</option>
                                    <option value="ingredients">Ingredients</option>
                                    <option value="supplies">Supplies</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="packaging">Packaging</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit of Measurement</label>
                                <select name="unit" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    <option value="">Select Unit</option>
                                    <option value="kg">Kilograms (kg)</option>
                                    <option value="g">Grams (g)</option>
                                    <option value="l">Liters (L)</option>
                                    <option value="ml">Milliliters (ml)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="box">Box</option>
                                    <option value="pack">Pack</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Information -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">Stock Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Stock</label>
                                <input type="number" name="current_stock" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock Level</label>
                                <input type="number" name="min_stock" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reorder Point</label>
                                <input type="number" name="reorder_point" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Information -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">Cost Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit Cost</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                                    <input type="number" name="unit_cost" min="0" step="0.01" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                                <input type="text" name="supplier" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">Additional Information</h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location in Storage</label>
                            <input type="text" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="e.g., Shelf A3, Box 2">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">Item Image</h4>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <div class="space-y-2">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                <div class="text-sm text-gray-500">
                                    <label for="item-image" class="relative cursor-pointer text-primary hover:text-primary/80">
                                        <span>Upload an image</span>
                                        <input type="file" id="item-image" name="image" class="sr-only" accept="image/*">
                                    </label>
                                    <p>or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-6">
                        <button type="button" onclick="closeAddItemModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                            Add Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAddItemModal() {
            document.getElementById('addItemModal').classList.remove('hidden');
            document.getElementById('addItemModal').classList.add('flex');
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').classList.add('hidden');
            document.getElementById('addItemModal').classList.remove('flex');
        }

        // Add event listener to the "Add New Item" button
        document.querySelector('button[onclick="showAddItemModal()"]')?.addEventListener('click', showAddItemModal);

        // Inventory search filter
        document.getElementById('inventorySearch').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(search)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <?php
    // SweetAlert feedback for add item
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['inventory_success'])) {
        echo "<script>Swal.fire({icon: 'success', title: 'Success', text: '" . $_SESSION['inventory_success'] . "'});</script>";
        unset($_SESSION['inventory_success']);
    }
    if (isset($_SESSION['inventory_error'])) {
        echo "<script>Swal.fire({icon: 'error', title: 'Error', text: '" . $_SESSION['inventory_error'] . "'});</script>";
        unset($_SESSION['inventory_error']);
    }
    ?>
</body>
</html>