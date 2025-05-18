<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userFullName = $_SESSION['fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Feedback</title>
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
                <a href="./loyalty-rewards.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-gift w-6"></i>
                    <span>Loyalty & Rewards</span>
                </a>
                <a href="./feedback.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
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
                    <h2 class="text-xl font-semibold text-gray-800">Feedback</h2>
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

            <!-- Feedback Content -->
            <main class="p-6">
                <!-- Feedback Form -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Submit Feedback</h3>
                    <form class="space-y-4">
                        <!-- Order Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Order</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Select an order...</option>
                                <option value="12345">Order #12345 - March 15, 2024</option>
                                <option value="12344">Order #12344 - March 8, 2024</option>
                            </select>
                        </div>

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex space-x-2">
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <i class="fas fa-star"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Feedback Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">What was good?</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                <label class="flex items-center space-x-2 p-2 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary">
                                    <span class="text-sm">Food Quality</span>
                                </label>
                                <label class="flex items-center space-x-2 p-2 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary">
                                    <span class="text-sm">Service</span>
                                </label>
                                <label class="flex items-center space-x-2 p-2 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary">
                                    <span class="text-sm">Delivery Time</span>
                                </label>
                                <label class="flex items-center space-x-2 p-2 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary">
                                    <span class="text-sm">Value for Money</span>
                                </label>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
                            <textarea 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                rows="4"
                                placeholder="Share your experience..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                            Submit Feedback
                        </button>
                    </form>
                </div>

                <!-- Past Feedback -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Your Past Feedback</h3>
                    <div class="space-y-4">
                        <!-- Feedback Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-medium">Order #12344</h4>
                                    <p class="text-sm text-gray-500">March 8, 2024</p>
                                </div>
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">Food Quality</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">Service</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">Value for Money</span>
                            </div>
                            <p class="text-gray-600">Great experience! The food was delicious and arrived hot. The delivery was prompt and the service was excellent.</p>
                        </div>

                        <!-- Feedback Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-medium">Order #12343</h4>
                                    <p class="text-sm text-gray-500">March 1, 2024</p>
                                </div>
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">Food Quality</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">Delivery Time</span>
                            </div>
                            <p class="text-gray-600">The food was good but delivery took longer than expected. Would order again but hope for better timing.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Star Rating Functionality
        const starButtons = document.querySelectorAll('.text-2xl');
        starButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Reset all stars
                starButtons.forEach(btn => {
                    btn.classList.remove('text-yellow-400');
                    btn.classList.add('text-gray-300');
                });
                // Fill stars up to clicked index
                for (let i = 0; i <= index; i++) {
                    starButtons[i].classList.remove('text-gray-300');
                    starButtons[i].classList.add('text-yellow-400');
                }
            });
        });
    </script>
</body>
</html>