<?php
include_once __DIR__ . '/auth/connection.php';

// --- FEEDBACK STATS ---
// Average Rating
$avgRating = 0;
$sql = "SELECT AVG(rating) as avg_rating FROM feedback";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $avgRating = round($row['avg_rating'], 2);
}

// Total Reviews
$totalReviews = 0;
$sql = "SELECT COUNT(id) as total FROM feedback";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $totalReviews = (int)$row['total'];
}

// Pending Responses (orders with order_status = 'Pending')
$pendingResponses = 0;
$sql = "SELECT COUNT(id) as total FROM orders WHERE order_status = 'Pending'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $pendingResponses = (int)$row['total'];
}

// Rating Distribution
$ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
$sql = "SELECT rating, COUNT(*) as cnt FROM feedback GROUP BY rating";
$result = $conn->query($sql);
$totalForDist = 0;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $r = (int)$row['rating'];
        if (isset($ratingCounts[$r])) {
            $ratingCounts[$r] = (int)$row['cnt'];
            $totalForDist += (int)$row['cnt'];
        }
    }
}

// Fetch recent reviews (latest 3)
$recentReviews = [];
$sql = "SELECT f.*, u.fullname FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.id DESC LIMIT 3";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recentReviews[] = $row;
    }
}
?>

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

        function exportFeedback() {
            window.location.href = 'auth/export_feedback.php';
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
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center" onclick="exportFeedback()">
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $avgRating; ?></h3>
                                <div class="flex items-center text-yellow-400">
                                    <?php
                                    $fullStars = floor($avgRating);
                                    $halfStar = ($avgRating - $fullStars) >= 0.5;
                                    for ($i = 0; $i < $fullStars; $i++) echo '<i class="fas fa-star"></i>';
                                    if ($halfStar) echo '<i class="fas fa-star-half-alt"></i>';
                                    for ($i = $fullStars + $halfStar; $i < 5; $i++) echo '<i class="far fa-star"></i>';
                                    ?>
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
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo number_format($totalReviews); ?></h3>
                                <!-- Optionally add a trend indicator here -->
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-comments text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Pending Responses</p>
                                <h3 class="text-2xl font-semibold text-gray-800"><?php echo $pendingResponses; ?></h3>
                                <p class="text-sm text-red-600"><?php echo $pendingResponses > 0 ? 'Requires attention' : 'All caught up!'; ?></p>
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
                            <?php
                            $total = $totalForDist > 0 ? $totalForDist : 1;
                            for ($star = 5; $star >= 1; $star--):
                                $count = $ratingCounts[$star];
                                $percent = round(($count / $total) * 100);
                            ?>
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600"><?php echo $star; ?> Star<?php echo $star > 1 ? 's' : ''; ?></div>
                                <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400" style="width: <?php echo $percent; ?>%"></div>
                                </div>
                                <div class="w-16 text-sm text-gray-600 text-right"><?php echo $count; ?></div>
                            </div>
                            <?php endfor; ?>
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
                            <?php foreach ($recentReviews as $review): ?>
                            <div class="border-b pb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($review['fullname'] ?? 'Anonymous'); ?>&background=E63946&color=fff" 
                                            alt="<?php echo htmlspecialchars($review['fullname'] ?? 'Anonymous'); ?>" 
                                            class="w-10 h-10 rounded-full">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($review['fullname'] ?? 'Anonymous'); ?></h4>
                                            <p class="text-xs text-gray-500"><?php echo date('F j, Y', strtotime($review['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-yellow-400">
                                        <?php
                                        $stars = (int)$review['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $stars) echo '<i class="fas fa-star"></i>';
                                            else echo '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">
                                    <?php echo htmlspecialchars($review['comments']); ?>
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
                            <?php endforeach; ?>
                            <?php if (empty($recentReviews)): ?>
                            <div class="text-gray-400 text-center py-8">No reviews yet.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>