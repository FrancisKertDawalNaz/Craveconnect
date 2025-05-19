<?php
include_once __DIR__ . '/auth/connection.php';
// Total Revenue (all time)
$totalRevenue = 0;
$sql = "SELECT SUM(total) FROM orders";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($totalRevenue);
    $stmt->fetch();
    $stmt->close();
}
if ($totalRevenue === null) $totalRevenue = 0;

// Total Orders (all time)
$totalOrders = 0;
$sql = "SELECT COUNT(*) FROM orders";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($totalOrders);
    $stmt->fetch();
    $stmt->close();
}

// Average Order Value (all time)
$avgOrderValue = 0;
$sql = "SELECT AVG(total) FROM orders";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($avgOrderValue);
    $stmt->fetch();
    $stmt->close();
}
if ($avgOrderValue === null) $avgOrderValue = 0;

// New Customers (last 30 days)
$newCustomers = 0;
$sql = "SELECT COUNT(*) FROM users WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($newCustomers);
    $stmt->fetch();
    $stmt->close();
}

// Fetch last 7 days revenue and order count
$revenueData = [];
$orderData = [];
$labels = [];
$sql = "SELECT DATE(order_date) as day, SUM(total) as revenue, COUNT(*) as orders FROM orders WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY day ORDER BY day ASC";
$result = $conn->query($sql);
$days = [];
$revenues = [];
$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $days[] = date('D', strtotime($row['day']));
        $revenues[] = (float)$row['revenue'];
        $orders[] = (int)$row['orders'];
    }
}
// Fill missing days with 0
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $label = date('D', strtotime($date));
    $labels[] = $label;
    $key = array_search($label, $days);
    if ($key !== false) {
        $revenueData[] = $revenues[$key];
        $orderData[] = $orders[$key];
    } else {
        $revenueData[] = 0;
        $orderData[] = 0;
    }
}

// Fetch top selling items (system-wide, top 3 for today)
$topSellingItems = array();
$sql = "SELECT item_name, SUM(quantity) as total_orders, SUM(total) as total_revenue FROM orders WHERE DATE(order_date) = CURDATE() GROUP BY item_name ORDER BY total_orders DESC LIMIT 3";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $topSellingItems[] = $row;
    }
}

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="analytics_report_' . date('Ymd') . '.csv"');
    $output = fopen('php://output', 'w');
    // Quick Stats
    fputcsv($output, ['Quick Stats']);
    fputcsv($output, ['Total Revenue', number_format($totalRevenue, 2)]);
    fputcsv($output, ['Total Orders', $totalOrders]);
    fputcsv($output, ['Average Order Value', number_format($avgOrderValue, 2)]);
    fputcsv($output, ['New Customers (30 days)', $newCustomers]);
    fputcsv($output, []);
    // Top Selling Products
    fputcsv($output, ['Top Selling Products']);
    fputcsv($output, ['Product Name', 'Orders', 'Revenue']);
    foreach ($topSellingItems as $item) {
        fputcsv($output, [
            $item['item_name'],
            $item['total_orders'],
            number_format($item['total_revenue'], 2)
        ]);
    }
    fclose($output);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h2 class="text-xl font-semibold text-gray-800">Analytics</h2>
                    <div class="flex items-center space-x-4">
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                            <option>Last Year</option>
                        </select>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center" onclick="window.location.href='?export=csv'">
                            <i class="fas fa-download mr-2"></i>
                            Export Report
                        </button>
                    </div>
                </div>
            </header>

            <!-- Analytics Content -->
            <main class="p-6">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Revenue</p>
                                <h3 class="text-2xl font-semibold text-gray-800">$<?php echo number_format($totalRevenue, 2); ?></h3>
                                <p class="text-sm text-green-600">&nbsp;</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Orders</p>
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo number_format($totalOrders); ?></h3>
                                <p class="text-sm text-green-600">&nbsp;</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Average Order Value</p>
                                <h3 class="text-2xl font-semibold text-gray-800">$<?php echo number_format($avgOrderValue, 2); ?></h3>
                                <p class="text-sm text-green-600">&nbsp;</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-chart-line text-purple-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">New Customers</p>
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo number_format($newCustomers); ?></h3>
                                <p class="text-sm text-green-600">&nbsp;</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-users text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Revenue Chart -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenue Overview</h3>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>

                    <!-- Orders Chart -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Trends</h3>
                        <canvas id="ordersChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Popular Products -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Top Selling Products</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <?php if (!empty($topSellingItems)): ?>
                                <?php foreach ($topSellingItems as $item): ?>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="p-3 bg-gray-100 rounded-full">
                                                <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900"><?php echo number_format($item['total_orders']); ?> orders</p>
                                            <p class="text-sm text-gray-500">$<?php echo number_format($item['total_revenue'], 2); ?> revenue</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-400">No top selling products today.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($revenueData); ?>,
                    borderColor: '#E63946',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return '$' + value; }
                        }
                    }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Orders',
                    data: <?php echo json_encode($orderData); ?>,
                    backgroundColor: '#E63946',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>