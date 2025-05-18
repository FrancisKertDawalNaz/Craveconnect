<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userFullName = $_SESSION['fullname'];

// Fetch user points
require_once '../auth/connection.php';
$userId = $_SESSION['user_id'];
$points = 0;
$pointsResult = $conn->query("SELECT points FROM users WHERE id = $userId");
if ($pointsResult && $row = $pointsResult->fetch_assoc()) {
    $points = $row['points'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Loyalty & Rewards</title>
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
    <!-- Hero Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="p-4 border-b">
                <h1 class="text-2xl font-bold text-primary">CraveConnect</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-4">
                <a href="./dashboard.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
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
                <a href="./loyalty-rewards.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
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
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Loyalty & Rewards</h2>
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

            <!-- Rewards Content -->
            <main class="p-6">
                <!-- Points Summary -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Your Points</h3>
                            <div class="flex items-baseline space-x-2">
                                <span class="text-3xl font-bold text-primary"><?php echo $points; ?></span>
                                <span class="text-gray-500">points</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Next Reward at</p>
                            <p class="text-lg font-semibold">2,000 points</p>
                        </div>
                    </div>
                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <?php
                        $nextReward = 2000;
                        $progress = min(100, ($points / $nextReward) * 100);
                        $pointsToNext = max(0, $nextReward - $points);
                        ?>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <?php echo $pointsToNext; ?> points to next reward
                        </p>
                    </div>
                </div>

                <!-- Available Rewards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Reward Card: Free Main Course (2000 points) -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gift text-primary text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-primary">2,000 points</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Free Main Course</h3>
                            <p class="text-gray-600 text-sm mb-4">Get any main course item for free, up to $25 value</p>
                            <?php if ($points >= 2000): ?>
                                <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                                    Redeem Now
                                </button>
                            <?php else: ?>
                                <button class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg font-medium" disabled>
                                    Not Enough Points
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reward Card: Free Appetizer (1000 points) -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gift text-primary text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-primary">1,000 points</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Free Appetizer</h3>
                            <p class="text-gray-600 text-sm mb-4">Get any appetizer for free, up to $15 value</p>
                            <?php if ($points >= 1000): ?>
                                <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                                    Redeem Now
                                </button>
                            <?php else: ?>
                                <button class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg font-medium" disabled>
                                    Not Enough Points
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reward Card: Free Dessert (500 points) -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gift text-primary text-xl"></i>
                                </div>
                                <span class="text-sm font-medium text-primary">500 points</span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">Free Dessert</h3>
                            <p class="text-gray-600 text-sm mb-4">Get any dessert for free, up to $10 value</p>
                            <?php if ($points >= 500): ?>
                                <button class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                                    Redeem Now
                                </button>
                            <?php else: ?>
                                <button class="w-full bg-gray-100 text-gray-700 py-2 rounded-lg font-medium" disabled>
                                    Not Enough Points
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Points History -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Points History</h3>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="divide-y">
                            <?php
                            // Fetch points history for this user
                            $history = [];
                            $sql = "SELECT type, reference, points, created_at FROM points_history WHERE user_id = ? ORDER BY created_at DESC LIMIT 20";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param('i', $userId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $history[] = $row;
                                }
                                $stmt->close();
                            }
                            if (count($history) > 0):
                                foreach ($history as $entry):
                                    $isEarn = $entry['type'] === 'earn';
                                    $color = $isEarn ? 'text-green-600' : 'text-red-600';
                                    $sign = $isEarn ? '+' : '-';
                                    $ref = htmlspecialchars($entry['reference']);
                                    $date = date('F j, Y', strtotime($entry['created_at']));
                                    $points = intval($entry['points']);
                            ?>
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium"><?php echo $ref; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $date; ?></p>
                                </div>
                                <span class="<?php echo $color; ?> font-medium"><?php echo $sign . $points; ?> points</span>
                            </div>
                            <?php endforeach; else: ?>
                            <div class="p-4 text-gray-400 text-center">No points history yet.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>