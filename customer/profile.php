<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userFullName = $_SESSION['fullname'];

// Fetch user profile from database
require_once '../auth/connection.php';
$userId = $_SESSION['user_id'];
$userProfile = [
    'fullname' => '',
    'email' => '',
    'phone' => ''
];
$sql = "SELECT fullname, email, phone FROM users WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($userProfile['fullname'], $userProfile['email'], $userProfile['phone']);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Profile</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a href="./feedback.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-comment-alt w-6"></i>
                    <span>Feedback</span>
                </a>
                <a href="./profile.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
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
                    <h2 class="text-xl font-semibold text-gray-800">Profile</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Welcome, <?php echo htmlspecialchars($userFullName); ?></span>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($userFullName); ?>&background=E63946&color=fff" 
                                alt="Profile" 
                                class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Profile Content -->
            <main class="p-6">
                <div class="bg-white rounded-lg shadow p-6 mb-6 max-w-xl mx-auto">
                    <h3 class="text-lg font-semibold mb-4">My Profile</h3>
                    <div class="flex items-center mb-6">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($userFullName); ?>&background=E63946&color=fff" class="w-20 h-20 rounded-full mr-6" alt="Profile">
                        <div>
                            <p class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($userFullName); ?></p>
                            <p class="text-gray-500">Customer</p>
                        </div>
                    </div>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['fullname']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['email']); ?>" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['phone']); ?>" readonly>
                        </div>
                        <button type="button" id="editProfileBtn" class="w-full bg-primary text-white py-2 rounded-lg hover:bg-primary/90 font-medium">
                            Edit Profile
                        </button>
                    </form>
                </div>
                <!-- Edit Profile Modal -->
                <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md relative">
                        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                        <h3 class="text-lg font-semibold mb-4">Edit Profile</h3>
                        <form id="editProfileForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="fullname" id="editFullName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['fullname']); ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="editEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['email']); ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" id="editPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" value="<?php echo htmlspecialchars($userProfile['phone']); ?>" required>
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
                        const fullname = document.getElementById('editFullName').value.trim();
                        const email = document.getElementById('editEmail').value.trim();
                        const phone = document.getElementById('editPhone').value.trim();
                        fetch('../auth/update_profile.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ fullname, email, phone })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
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
