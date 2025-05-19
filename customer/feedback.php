<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userFullName = $_SESSION['fullname'];

// Fetch user's orders for feedback dropdown
require_once '../auth/connection.php';
$userId = $_SESSION['user_id'];
$orders = [];
$sql = "SELECT id, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $stmt->close();
}

// Handle feedback form submission
$feedbackMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $rating = intval($_POST['rating'] ?? 0);
    $categories = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '';
    $comments = trim($_POST['comments'] ?? '');
    if ($order_id && $rating) {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, order_id, rating, categories, comments) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iiiss', $userId, $order_id, $rating, $categories, $comments);
        if ($stmt->execute()) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                // AJAX: return only the message, no redirect
                header('Content-Type: text/plain');
                echo 'Feedback submitted!';
                exit();
            } else {
                // Redirect after POST to prevent resubmission on refresh
                header('Location: feedback.php');
                exit();
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: text/plain');
                echo 'Error saving feedback.';
                exit();
            } else {
                $feedbackMsg = '<div class="bg-red-100 text-red-700 p-2 rounded mb-4">Error saving feedback.</div>';
            }
        }
        $stmt->close();
    } else {
        $feedbackMsg = '<div class="bg-red-100 text-red-700 p-2 rounded mb-4">Please select an order and rating.</div>';
    }
}
// removed green message on reload

// Fetch user's feedback history
$feedbacks = [];
$sql = "SELECT f.*, o.id as order_id, o.order_date FROM feedback f LEFT JOIN orders o ON f.order_id = o.id WHERE f.user_id = ? ORDER BY f.created_at DESC";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
    $stmt->close();
}

// Pagination for feedbacks
$feedbacksPerPage = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$totalFeedbacks = count($feedbacks);
$totalPages = ceil($totalFeedbacks / $feedbacksPerPage);
$startIndex = ($page - 1) * $feedbacksPerPage;
$paginatedFeedbacks = array_slice($feedbacks, $startIndex, $feedbacksPerPage);
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
                    <?php if (!empty($feedbackMsg)) echo $feedbackMsg; ?>
                    <form class="space-y-4" method="POST" id="feedbackForm">
                        <!-- Order Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Order</label>
                            <select name="order_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                <option value="">Select an order...</option>
                                <?php foreach ($orders as $order): ?>
                                    <option value="<?php echo $order['id']; ?>">Order #<?php echo $order['id']; ?> - <?php echo date('M d, Y', strtotime($order['order_date'])); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label>
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" class="hidden" required>
                                        <i class="fas fa-star text-2xl text-gray-300 hover:text-yellow-400 cursor-pointer"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Feedback Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">What was good?</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                <?php $cats = ['Food Quality','Service','Delivery Time','Value for Money']; foreach ($cats as $cat): ?>
                                <label class="flex items-center space-x-2 p-2 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="categories[]" value="<?php echo $cat; ?>" class="rounded text-primary focus:ring-primary">
                                    <span class="text-sm"><?php echo $cat; ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
                            <textarea name="comments" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" rows="4" placeholder="Share your experience..."></textarea>
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
                        <?php if (count($paginatedFeedbacks) > 0): ?>
                            <?php foreach ($paginatedFeedbacks as $fb): ?>
                                <div class="bg-white rounded-lg shadow p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="font-medium">Order #<?php echo $fb['order_id']; ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo date('M d, Y', strtotime($fb['order_date'])); ?></p>
                                        </div>
                                        <div class="flex text-yellow-400">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?php echo $i <= $fb['rating'] ? 'fas' : 'far'; ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <?php foreach (explode(',', $fb['categories']) as $cat): if ($cat): ?>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-sm rounded-full"><?php echo htmlspecialchars($cat); ?></span>
                                        <?php endif; endforeach; ?>
                                    </div>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($fb['comments']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-gray-400 text-center">No feedback yet.</div>
                        <?php endif; ?>
                    </div>
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center mt-6 space-x-2">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="px-3 py-1 rounded-lg <?php echo $i == $page ? 'bg-primary text-white' : 'border hover:bg-gray-50'; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // AJAX Feedback Submit with SweetAlert
        document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            // Mark as AJAX
            formData.append('ajax', '1');
            const res = await fetch('', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });
            const msg = await res.text();
            if (msg && msg.indexOf('Feedback submitted') !== -1) {
                Swal.fire({ icon: 'success', title: 'Thank you!', text: msg, confirmButtonColor: '#E63946' }).then(() => window.location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: msg || 'Please check your input.', confirmButtonColor: '#E63946' });
            }
        });
    </script>
</body>
</html>