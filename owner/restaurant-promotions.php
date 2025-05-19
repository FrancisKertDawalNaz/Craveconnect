<?php
// Database connection
include_once __DIR__ . '/auth/connection.php';

// Fetch promotion stats from the database
$stats = [
    'active_promotions' => 0,
    'loyalty_members' => 0,
    'points_redeemed' => 0,
    'total_discounts' => 0.00
];

// Count active promotions
$sql = "SELECT COUNT(*) as total FROM promotions WHERE status = 'active' AND start_date <= CURDATE() AND end_date >= CURDATE()";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $stats['active_promotions'] = (int)$row['total'];
}

// Count loyalty members (unique users in points_history)
$sql = "SELECT COUNT(DISTINCT user_id) as total FROM points_history";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $stats['loyalty_members'] = (int)$row['total'];
}

// Points redeemed (sum of points in points_history)
$sql = "SELECT SUM(points) as total FROM points_history WHERE points IS NOT NULL";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $stats['points_redeemed'] = (int)$row['total'];
}

// Total discounts (sum of discount column in promotions table)
$sql = "SELECT SUM(discount) as total FROM promotions WHERE discount IS NOT NULL";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $stats['total_discounts'] = (float)$row['total'];
}

// Fetch active promotions for JS (if needed, you can use PHP to render instead of JS fetch)
$active_promotions = [];
$sql = "SELECT name, description, discount, end_date FROM promotions WHERE status = 'active' AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY end_date ASC LIMIT 10";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $active_promotions[] = $row;
    }
}
?>

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
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center" onclick="showCreatePromotionModal()">
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $stats['active_promotions']; ?></h3>
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $stats['loyalty_members']; ?></h3>
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $stats['points_redeemed']; ?></h3>
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo is_numeric($stats['total_discounts']) ? number_format($stats['total_discounts'], 2) : '0.00'; ?></h3>
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
                    <div class="p-6" id="active-promotions-list">
                        <div class="space-y-4">
                            <!-- Promotions will be loaded here by JS -->
                            <?php foreach ($active_promotions as $promo): ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-red-100 rounded-full">
                                        <i class="fas fa-percentage text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900"><?php echo $promo['name']; ?></h4>
                                        <p class="text-sm text-gray-500"><?php echo $promo['description']; ?> (<?php echo $promo['discount']; ?>% off)</p>
                                        <p class="text-xs text-gray-400">Valid until <?php echo date('F j, Y', strtotime($promo['end_date'])); ?></p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
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

    <!-- Create Promotion Modal -->
    <div id="createPromotionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4 max-h-[90vh] flex flex-col overflow-y-auto">
            <div class="p-6 border-b flex-shrink-0">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-semibold">Create Promotion</h3>
                    <button onclick="closeCreatePromotionModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <form class="p-6 space-y-4" id="createPromotionForm">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Promotion Name</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount (%)</label>
                        <input type="number" min="0" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-6">
                    <button type="button" onclick="closeCreatePromotionModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                        Save Promotion
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function showCreatePromotionModal() {
        document.getElementById('createPromotionModal').classList.remove('hidden');
        document.getElementById('createPromotionModal').classList.add('flex');
    }
    function closeCreatePromotionModal() {
        document.getElementById('createPromotionModal').classList.add('hidden');
        document.getElementById('createPromotionModal').classList.remove('flex');
    }

    // Fetch and render active promotions
    async function loadActivePromotions() {
        const container = document.querySelector('#active-promotions-list .space-y-4');
        container.innerHTML = '<div class="text-gray-400 text-center">Loading...</div>';
        try {
            const res = await fetch('auth/get_active_promotions.php');
            const promos = await res.json();
            if (promos.length === 0) {
                container.innerHTML = '<div class="text-gray-400 text-center">No active promotions.</div>';
                return;
            }
            container.innerHTML = '';
            promos.forEach(promo => {
                container.innerHTML += `
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-red-100 rounded-full">
                            <i class="fas fa-percentage text-primary text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">${promo.name}</h4>
                            <p class="text-sm text-gray-500">${promo.description} (${promo.discount}% off)</p>
                            <p class="text-xs text-gray-400">Valid until ${formatDate(promo.end_date)}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
                `;
            });
        } catch (e) {
            container.innerHTML = '<div class="text-red-400 text-center">Failed to load promotions.</div>';
        }
    }
    function formatDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    loadActivePromotions();

    // Handle Promotion Form Submission
    document.getElementById('createPromotionForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        // Map form fields to PHP expected names
        const data = {
            name: form.elements[0].value,
            description: form.elements[1].value,
            discount: form.elements[2].value,
            status: form.elements[3].value,
            start_date: form.elements[4].value,
            end_date: form.elements[5].value
        };
        try {
            const response = await fetch('auth/insert_promotion.php', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new URLSearchParams(data)
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    confirmButtonColor: '#E63946'
                }).then(() => {
                    closeCreatePromotionModal();
                    form.reset();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                    confirmButtonColor: '#E63946'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred.',
                confirmButtonColor: '#E63946'
            });
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>