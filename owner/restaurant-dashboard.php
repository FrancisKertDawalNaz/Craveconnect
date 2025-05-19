<?php
session_start();
include './auth/connection.php';



// Fetch active orders count (system-wide)
$activeOrders = 0;
$sql = "SELECT COUNT(*) as cnt FROM orders WHERE order_status IN ('Pending', 'Preparing')";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($activeOrders);
    $stmt->fetch();
    $stmt->close();
}

// Fetch today's revenue (system-wide)
$orders_total = 0.00;
$sql = "SELECT SUM(quantity * price) as total FROM orders WHERE DATE(order_date) = CURDATE()";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($orders_total);
    $stmt->fetch();
    $stmt->close();
}
if ($orders_total === null) {
    $orders_total = 0.00;
}

// Fetch active customers for today (system-wide)
$activeCustomers = 0;
$sql = "SELECT COUNT(DISTINCT user_id) FROM orders WHERE DATE(order_date) = CURDATE() AND user_id IS NOT NULL";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($activeCustomers);
    $stmt->fetch();
    $stmt->close();
}

// Fetch average rating for all feedback (not filtered by user_id)
$averageRating = 0;
$sql = "SELECT AVG(rating) FROM feedback";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($averageRating);
    $stmt->fetch();
    $stmt->close();
}
if ($averageRating === null) {
    $averageRating = 0;
}
if ($averageRating < 0) {
    $averageRating = abs($averageRating);
}

// Fetch recent orders (system-wide, latest 5)
$recentOrders = array();
$sql = "SELECT item_name, quantity, (quantity * price) as total, order_status FROM orders ORDER BY order_date DESC LIMIT 5";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($item_name, $quantity, $total, $order_status);
    while ($stmt->fetch()) {
        $recentOrders[] = array(
            'item_name' => $item_name ? $item_name : 'N/A',
            'quantity' => $quantity,
            'total' => $total,
            'order_status' => $order_status
        );
    }
    $stmt->close();
}

// Fetch top selling items (system-wide, top 3 for today)
$topSellingItems = array();
$sql = "SELECT item_name, SUM(quantity) as total_orders, MAX(price) as price FROM orders WHERE DATE(order_date) = CURDATE() GROUP BY item_name ORDER BY total_orders DESC LIMIT 3";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($item_name, $total_orders, $price);
    while ($stmt->fetch()) {
        $topSellingItems[] = array(
            'item_name' => $item_name,
            'total_orders' => $total_orders,
            'price' => $price
        );
    }
    $stmt->close();
}
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
                                <p class="text-2xl font-semibold"><?php echo $activeOrders; ?></p>
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
                                <p class="text-2xl font-semibold"><?php echo $orders_total !== null ? number_format($orders_total, 2) : '0.00'; ?></p>
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
                                <p class="text-2xl font-semibold"><?php echo $activeCustomers; ?></p>
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
                                <p class="text-2xl font-semibold"><?php echo $averageRating > 0 ? number_format($averageRating, 2) : 'N/A'; ?></p>
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
                                        <th class="pb-4">Item Name</th>
                                        <th class="pb-4">Items</th>
                                        <th class="pb-4">Total</th>
                                        <th class="pb-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    <?php if (count($recentOrders) > 0): ?>
                                        <?php foreach ($recentOrders as $order): ?>
                                            <tr class="border-t">
                                                <td class="py-4"><?php echo htmlspecialchars($order['item_name']); ?></td>
                                                <td><?php echo htmlspecialchars($order['quantity']); ?> items</td>
                                                <td><?php echo number_format($order['total'], 2); ?></td>
                                                <td><span class="px-2 py-1 rounded-full text-sm
    <?php
                                            if ($order['order_status'] === 'Approved') echo 'bg-green-500 text-white';
                                            else if ($order['order_status'] === 'Pending') echo 'bg-yellow-100 text-yellow-800';
                                            else if ($order['order_status'] === 'Preparing') echo 'bg-blue-100 text-blue-600';
                                            else if ($order['order_status'] === 'Completed') echo 'bg-gray-200 text-gray-600';
                                            else if ($order['order_status'] === 'Cancelled') echo 'bg-red-100 text-red-600';
                                            else echo 'bg-gray-100 text-gray-700';
    ?>">
                                                        <?php echo htmlspecialchars($order['order_status']); ?>
                                                    </span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-gray-400">No recent orders found.</td>
                                        </tr>
                                    <?php endif; ?>
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
                            <?php if (count($topSellingItems) > 0): ?>
                                <?php foreach ($topSellingItems as $item): ?>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <h4 class="text-gray-800"><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                                <p class="text-sm text-gray-500">&nbsp;</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-800"><?php echo number_format($item['price'], 2); ?></p>
                                            <p class="text-sm text-gray-500"><?php echo $item['total_orders']; ?> orders today</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-400">No top selling items today.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>