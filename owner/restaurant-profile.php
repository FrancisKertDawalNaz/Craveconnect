<?php
session_start();
// Check if owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header("Location: restaurant-login.php");
    exit();
}
$owner_id = $_SESSION['owner_id'];

require_once __DIR__ . '/auth/connection.php';
// Fetch restaurant owner profile from database using owner_id
$sql = "SELECT * FROM restaurant_owners WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $owner_id);
$stmt->execute();
$result = $stmt->get_result();
$restaurant = $result->fetch_assoc();
$stmt->close();

// Set default values if not found
$restaurant = $restaurant ?: [
    'restaurant_name' => '',
    'cuisine_type' => '',
    'phone' => '',
    'email' => '',
    'restaurant_address' => '',
    'description' => '',
    'fullname' => '',
    'position' => '',
    'owner_phone' => '',
    'owner_email' => ''
];
$restaurantName = $restaurant['restaurant_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Restaurant Profile</title>
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
                <a href="./restaurant-profile.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
                    <i class="fas fa-user w-6"></i>
                    <span>Profile</span>
                </a>
                <a href="restaurant-login.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary mt-4">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Restaurant Profile</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            Welcome, <?php echo isset($_SESSION['owner_name']) ? htmlspecialchars($_SESSION['owner_name']) : 'Restaurant Owner'; ?>
                        </span>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($restaurantName); ?>&background=E63946&color=fff" 
                                alt="Profile" 
                                class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                </div>
            </header>
            <main class="p-6">
                <div class="bg-white rounded-lg shadow p-4 mb-6 max-w-md w-full max-h-[80vh] overflow-y-auto mx-auto">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($restaurantName); ?>&background=E63946&color=fff" class="w-16 h-16 rounded-full mr-4" alt="Profile">
                        <div>
                            <p class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($restaurantName); ?></p>
                            <p class="text-gray-500">Restaurant</p>
                        </div>
                    </div>
                    <form class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Restaurant Name</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['restaurant_name']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cuisine Type</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['cuisine_type']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['phone']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['email']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['restaurant_address']); ?>" readonly>
                        </div>
                        <button type="button" id="editProfileBtn" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                            Edit Profile
                        </button>
                    </form>
                </div>
                <!-- Edit Profile Modal -->
                <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl relative">
                        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                        <h3 class="text-lg font-semibold mb-4">Edit Profile</h3>
                        <form id="editProfileForm" class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="fullname" id="editFullname" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['fullname']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" id="editEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['email']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" name="phone" id="editPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($restaurant['phone']); ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">Save Changes</button>
                        </form>
                    </div>
                </div>
                <script>
                // Modal open/close logic
                const editProfileBtn = document.getElementById('editProfileBtn');
                const editProfileModal = document.getElementById('editProfileModal');
                const closeModalBtn = document.getElementById('closeModalBtn');
                if (editProfileBtn && editProfileModal && closeModalBtn) {
                    editProfileBtn.addEventListener('click', function() {
                        editProfileModal.classList.remove('hidden');
                    });
                    closeModalBtn.addEventListener('click', function() {
                        editProfileModal.classList.add('hidden');
                    });
                    window.addEventListener('click', function(e) {
                        if (e.target === editProfileModal) {
                            editProfileModal.classList.add('hidden');
                        }
                    });
                }
                // Handle profile update form submit
                const editProfileForm = document.getElementById('editProfileForm');
                if (editProfileForm) {
                    editProfileForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(editProfileForm);
                        fetch('auth/update_profile.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', data.message || 'Profile updated successfully!', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Failed to update profile.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        });
                    });
                }
                </script>
            </main>
        </div>
    </div>
</body>
</html>