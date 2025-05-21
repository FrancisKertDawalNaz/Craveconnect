<?php
include_once __DIR__ . '/auth/connection.php';

// Pagination logic
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$ordersPerPage = 4;
$offset = ($page - 1) * $ordersPerPage;
$totalOrders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$totalPages = ceil($totalOrders / $ordersPerPage);

$sql = "SELECT * FROM orders ORDER BY id DESC LIMIT $ordersPerPage OFFSET $offset";
$result = mysqli_query($conn, $sql);
$orders = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
}

$searchOrder = isset($_GET['search_order']) ? intval($_GET['search_order']) : 0;
if ($searchOrder > 0) {
    $sql = "SELECT * FROM orders WHERE id = $searchOrder";
    $result = mysqli_query($conn, $sql);
    $orders = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }
    // Override pagination for search
    $totalPages = 1;
    $page = 1;
} else {
    $totalOrders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
    $totalPages = ceil($totalOrders / $ordersPerPage);
}
?>
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
                    <h2 class="text-xl font-semibold text-gray-800">Orders Management</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <form method="get" action="" class="flex items-center">
                                <input type="number" name="search_order" min="1" placeholder="Search order #..." value="<?php echo isset($_GET['search_order']) ? intval($_GET['search_order']) : ''; ?>"
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <button type="submit" class="absolute left-3 top-3 text-gray-400"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Orders Content -->
            <main class="p-6">
                <!-- Order Status Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-4 border-b">
                        <button class="px-4 py-2 text-primary border-b-2 border-primary font-medium">All Orders</button>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-4">
                    <?php if (!empty($orders)): ?>
                        <?php 
                        // Collect user IDs for batch query
                        $userIds = array_map(function($order) { return (int)$order['user_id']; }, $orders);
                        $userPhones = [];
                        if (!empty($userIds)) {
                            $ids = implode(',', $userIds);
                            $userResult = mysqli_query($conn, "SELECT id, phone FROM users WHERE id IN ($ids)");
                            if ($userResult && mysqli_num_rows($userResult) > 0) {
                                while ($u = mysqli_fetch_assoc($userResult)) {
                                    $userPhones[$u['id']] = $u['phone'];
                                }
                            }
                        }
                        ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="bg-white rounded-lg shadow">
                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">Order #<?php echo htmlspecialchars($order['id']); ?></h3>
                                            <p class="text-sm text-gray-500">Placed on <?php echo date('F j, Y - h:i A', strtotime($order['order_date'])); ?></p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                        <?php
                                        if ($order['order_status'] === 'New') echo 'bg-yellow-100 text-yellow-600';
                                        else if ($order['order_status'] === 'Preparing') echo 'bg-blue-100 text-blue-600';
                                        else if ($order['order_status'] === 'Ready') echo 'bg-green-100 text-green-600';
                                        else if ($order['order_status'] === 'Approved') echo 'bg-green-500 text-white';
                                        else if ($order['order_status'] === 'Completed') echo 'bg-gray-200 text-gray-600';
                                        else if ($order['order_status'] === 'Cancelled') echo 'bg-red-100 text-red-600';
                                        else echo 'bg-gray-100 text-gray-600';
                                        ?>
">
                                            <?php echo htmlspecialchars($order['order_status']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Customer ID:</span>
                                            <span class="font-medium"><?php echo htmlspecialchars($order['user_id']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Phone:</span>
                                            <span class="font-medium"><?php echo isset($userPhones[$order['user_id']]) ? htmlspecialchars($userPhones[$order['user_id']]) : 'N/A'; ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Item:</span>
                                            <span class="font-medium"><?php echo htmlspecialchars($order['item_name']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Quantity:</span>
                                            <span class="font-medium"><?php echo htmlspecialchars($order['quantity']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Price:</span>
                                            <span class="font-medium"><?php echo number_format($order['price'], 2); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Total:</span>
                                            <span class="font-medium text-primary"><?php echo number_format($order['total'], 2); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Order Type:</span>
                                            <span class="font-medium"><?php echo htmlspecialchars($order['order_type']); ?></span>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end space-x-3">
                                        <button class="px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg border view-details-btn"
                                            data-order-id="<?php echo $order['id']; ?>"
                                            data-order-status="<?php echo htmlspecialchars($order['order_status']); ?>">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center text-gray-400">No orders found.</div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center" <?php if ($totalPages <= 1) echo 'style="display:none;"'; ?>>
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50" 
                            onclick="window.location.href='?page=' + (<?php echo $page > 1 ? $page - 1 : 1; ?>)" <?php if ($page <= 1) echo 'disabled'; ?>>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <button class="px-3 py-1 rounded-lg <?php echo $i == $page ? 'bg-primary text-white' : 'border hover:bg-gray-50'; ?>" 
                                onclick="window.location.href='?page=<?php echo $i; ?>'">
                                <?php echo $i; ?>
                            </button>
                        <?php endfor; ?>
                        <button class="px-3 py-1 rounded-lg border hover:bg-gray-50" 
                            onclick="window.location.href='?page=' + (<?php echo $page < $totalPages ? $page + 1 : $totalPages; ?>)" <?php if ($page >= $totalPages) echo 'disabled'; ?>>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('.view-details-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const orderStatus = this.getAttribute('data-order-status');
                let html = `<p>Status: <b>${orderStatus}</b></p>`;
                if (orderStatus === 'Ready' || orderStatus === 'Pending') {
                    html += `<button id='approveBtn' class='swal2-confirm swal2-styled' style='background-color:#3b82f6;'>Approve Order</button>`;
                }
                Swal.fire({
                    title: `Order #${orderId} Details`,
                    html: html,
                    showConfirmButton: false,
                    showCloseButton: true,
                    didOpen: () => {
                        const approveBtn = document.getElementById('approveBtn');
                        if (approveBtn) {
                            approveBtn.addEventListener('click', function() {
                                approveBtn.disabled = true;
                                approveBtn.textContent = 'Approving...';
                                fetch('auth/approve_order.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `order_id=${orderId}`
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Approved!', 'Order has been approved.', 'success').then(() => window.location.reload());
                                        } else {
                                            Swal.fire('Error', 'Failed to approve order.', 'error');
                                        }
                                    })
                                    .catch(() => {
                                        Swal.fire('Error', 'Failed to approve order.', 'error');
                                    });
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>