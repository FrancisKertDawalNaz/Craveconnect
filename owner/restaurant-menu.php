<?php
session_start();

// Database connection
include_once __DIR__ . '/auth/connection.php';

$selected_category = isset($_GET['category']) ? $_GET['category'] : '';
$menu_items = [];
if ($selected_category && $selected_category !== 'All') {
    $sql = "SELECT * FROM menu_items WHERE category = '" . mysqli_real_escape_string($conn, $selected_category) . "' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM menu_items ORDER BY id DESC";
}
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $menu_items[] = $row;
    }
}
?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<?php
if (isset($_SESSION['menu_item_added']) && $_SESSION['menu_item_added']) {
    echo "<script>Swal.fire({icon: 'success',title: 'Success!',text: 'Menu item added successfully!',showConfirmButton: false,timer: 2000});</script>";
    unset($_SESSION['menu_item_added']);
}
?>
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
                <a href="auth/logout.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary mt-4">
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
                <!-- Error Message -->
                <?php if (isset($_SESSION['menu_error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4">
                        <?php echo htmlspecialchars($_SESSION['menu_error']); unset($_SESSION['menu_error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Categories -->
                <div class="mb-6">
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        <a href="?category=All" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo !$selected_category || $selected_category === 'All' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">All Menu</a>
                        <a href="?category=Lomi" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo $selected_category === 'Lomi' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">Lomi</a>
                        <a href="?category=Silog Meal" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo $selected_category === 'Silog Meal' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">Silog Meal</a>
                        <a href="?category=Lutong Ulam" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo $selected_category === 'Lutong Ulam' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">Lutong Ulam</a>
                        <a href="?category=Lugaw" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo $selected_category === 'Lugaw' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">Lugaw</a>
                        <a href="?category=Short Order" class="px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent <?php echo $selected_category === 'Short Order' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50'; ?>">Short Order</a>
                    </div>
                </div>

                <!-- Menu Items Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (!empty($menu_items)): ?>
                        <?php foreach ($menu_items as $item): ?>
                        <div class="bg-white rounded-lg shadow">
                            <div class="relative">
                                <img src="<?php echo !empty($item['image_url']) ? 'uploads/' . htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/400x300?text=No+Image'; ?>"
                                    alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                                    class="w-full h-48 object-cover rounded-t-lg">
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                        <i class="fas fa-edit text-gray-600"></i>
                                    </button>
                                    <button onclick="openDeleteModal(<?php echo $item['id']; ?>)" class="p-2 bg-white rounded-full shadow hover:bg-gray-50">
                                        <i class="fas fa-trash text-red-500"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($item['category']); ?></p>
                                    </div>
                                    <span class="text-lg font-semibold text-primary"><?php echo number_format($item['price'], 2); ?></span>
                                </div>
                                <p class="mt-2 text-gray-600 text-sm"><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-3 text-center text-gray-500">No menu items found.</div>
                    <?php endif; ?>
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
                                <option value="Lomi">Lomi</option>
                                <option value="Silog Meal">Silog Meal</option>
                                <option value="Lutong Ulam">Lutong Ulam</option>
                                <option value="Lugaw">Lugaw</option>
                                <option value="Short Order">Short Order</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                            <div class="relative">
                                <input type="number" name="price" required
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="00">
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

        // Edit Modal
        function openEditModal(item) {
            Swal.fire({
                title: 'Edit Menu Item',
                html: `
                    <input id="swal-item-name" class="swal2-input" placeholder="Item Name" value="${item.item_name || ''}">
                    <input id="swal-category" class="swal2-input" placeholder="Category" value="${item.category || ''}">
                    <input id="swal-price" type="number" step="0.01" class="swal2-input" placeholder="Price" value="${item.price || ''}">
                    <textarea id="swal-description" class="swal2-textarea" placeholder="Description">${item.description || ''}</textarea>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    return {
                        id: item.id,
                        item_name: document.getElementById('swal-item-name').value,
                        category: document.getElementById('swal-category').value,
                        price: document.getElementById('swal-price').value,
                        description: document.getElementById('swal-description').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX request to update the menu item
                    fetch('./auth/update_menu.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(result.value)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Saved!', 'Menu item updated.', 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.error || 'Failed to update menu item.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Failed to update menu item.', 'error');
                    });
                }
            });
        }

        // Delete Modal
        function openDeleteModal(itemId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the menu item.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E63946',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect or AJAX to delete
                    window.location.href = './auth/delete_menu.php?id=' + itemId;
                }
            });
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