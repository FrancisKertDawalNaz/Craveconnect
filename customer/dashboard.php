<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userFullName = $_SESSION['fullname'];

// Fetch active orders count for this user
require_once '../auth/connection.php';
$activeOrders = 0;
$userId = $_SESSION['user_id'];
$sql = "SELECT COUNT(*) as cnt FROM orders WHERE user_id = ? AND order_status IN ('Pending', 'Preparing')";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($activeOrders);
    $stmt->fetch();
    $stmt->close();
}

// Fetch recent orders for this user
$recentOrders = [];
$sqlRecent = "SELECT id, item_name, quantity, total, order_status, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC LIMIT 5";
if ($stmt = $conn->prepare($sqlRecent)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $recentOrders[] = $row;
    }
    $stmt->close();
}

// Fetch user points
$points = 0;
$pointsResult = $conn->query("SELECT points FROM users WHERE id = $userId");
if ($pointsResult && $row = $pointsResult->fetch_assoc()) {
    $points = $row['points'];
}

// Fetch available rewards for this user
$availableRewards = 0;
if ($points >= 2000) $availableRewards++;
if ($points >= 1000) $availableRewards++;
if ($points >= 500) $availableRewards++;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CraveConnect - Customer Dashboard</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4 border-b">
                <h1 class="text-2xl font-bold text-primary">CraveConnect</h1>
            </div>
            <nav class="mt-4">
                <a href="./dashboard.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./menu.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-utensils w-6"></i>
                    <span>Menu</span>
                </a>
                <a href="./my-orders.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-shopping-bag w-6"></i>
                    <span>My Orders</span>
                </a>
                <a href="./loyalty-rewards.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-gift w-6"></i>
                    <span>Loyalty & Rewards</span>
                </a>
                <a href="./feedback.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-comment-alt w-6"></i>
                    <span>Feedback</span>
                </a>
                <a href="./profile.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-user w-6"></i>
                    <span>Profile</span>
                </a>
                <a href="../auth/logout.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary mt-4">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Welcome, <?php echo htmlspecialchars($userFullName); ?></span>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($userFullName); ?>&background=E63946&color=fff"
                                alt="Profile"
                                class="w-8 h-8 rounded-full" />
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary/10 text-primary">
                                <i class="fas fa-shopping-bag text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Active Orders</h3>
                                <p class="text-2xl font-semibold"><?php echo $activeOrders; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary/10 text-primary">
                                <i class="fas fa-gift text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Loyalty Points</h3>
                                <p class="text-2xl font-semibold"><?php echo $points; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary/10 text-primary">
                                <i class="fas fa-tag text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Available Rewards</h3>
                                <p class="text-2xl font-semibold"><?php echo $availableRewards; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold">Recent Orders</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100" style="scrollbar-width: thin;">
                            <?php if (count($recentOrders) > 0): ?>
                                <?php foreach ($recentOrders as $order): ?>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium">Order #<?php echo $order['id']; ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($order['quantity'] . ' x ' . $order['item_name'] . ' • $' . number_format($order['total'], 2)); ?></p>
                                            <p class="text-xs text-gray-400"><?php echo date('M d, Y h:i A', strtotime($order['order_date'])); ?></p>
                                        </div>
                                        <?php
                                        $status = $order['order_status'];
                                        $statusClass = 'bg-gray-200 text-gray-700';
                                        if ($status === 'Pending') $statusClass = 'bg-yellow-100 text-yellow-800';
                                        else if ($status === 'Preparing') $statusClass = 'bg-yellow-200 text-yellow-900';
                                        else if ($status === 'Completed') $statusClass = 'bg-green-100 text-green-800';
                                        else if ($status === 'Approved') $statusClass = 'bg-green-500 text-white';
                                        else if ($status === 'Cancelled') $statusClass = 'bg-red-100 text-red-800';
                                        ?>
                                        <span class="px-3 py-1 text-sm rounded-full <?php echo $statusClass; ?>">
                                            <?php echo htmlspecialchars($status); ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-gray-400 text-center">No recent orders found.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
