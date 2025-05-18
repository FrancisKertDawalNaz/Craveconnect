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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CraveConnect - Menu</title>
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
                <a href="./dashboard.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                <a href="./menu.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
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
                    <h2 class="text-xl font-semibold text-gray-800">Menu</h2>
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <img src="../assets/images/view-ready-eat-delicious-meal-go.jpg" alt="Burger" class="rounded mb-4">
                        <h3 class="text-lg font-semibold mb-2">Classic Burger</h3>
                        <p class="text-gray-600 mb-2">Juicy beef patty with fresh lettuce, tomato, and cheese.</p>
                        <p class="text-primary font-bold">$8.99</p>
                        <button onclick="openModal(0)" class="mt-2 w-full bg-primary text-white py-2 rounded hover:bg-red-700 transition">Add to Cart</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <img src="../assets/images/slice-cut-from-classic-pepperoni-pizza-with-green-pepper-rolls.jpg" alt="Pizza" class="rounded mb-4">
                        <h3 class="text-lg font-semibold mb-2">Pepperoni Pizza</h3>
                        <p class="text-gray-600 mb-2">Thin crust pizza topped with pepperoni and mozzarella cheese.</p>
                        <p class="text-primary font-bold">$12.50</p>
                        <button onclick="openModal(1)" class="mt-2 w-full bg-primary text-white py-2 rounded hover:bg-red-700 transition">Add to Cart</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <img src="../assets/images/caesar-salad-with-grilled-chicken-breast-parmesan-cherry-tomatoes.jpg" alt="Salad" class="rounded mb-4">
                        <h3 class="text-lg font-semibold mb-2">Caesar Salad</h3>
                        <p class="text-gray-600 mb-2">Fresh romaine lettuce, parmesan, croutons, and Caesar dressing.</p>
                        <p class="text-primary font-bold">$7.00</p>
                        <button onclick="openModal(2)" class="mt-2 w-full bg-primary text-white py-2 rounded hover:bg-red-700 transition">Add to Cart</button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div id="orderModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Order Item</h2>
            <img id="modalImage" src="" alt="Food" class="rounded mb-4 w-full h-40 object-cover">
            <p class="mb-2" id="modalDesc"></p>
            <p class="font-bold text-primary mb-4" id="modalPrice"></p>
            <form>
                <label class="block mb-2 font-semibold">Quantity</label>
                <input type="number" min="1" value="1" class="w-full border rounded px-3 py-2 mb-4" id="modalQty">
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-primary text-white hover:bg-red-700">Order Now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Modal logic
    const items = [
        {
            title: 'Classic Burger',
            desc: 'Juicy beef patty with fresh lettuce, tomato, and cheese.',
            price: '$8.99',
            img: '../assets/images/view-ready-eat-delicious-meal-go.jpg'
        },
        {
            title: 'Pepperoni Pizza',
            desc: 'Thin crust pizza topped with pepperoni and mozzarella cheese.',
            price: '$12.50',
            img: '../assets/images/slice-cut-from-classic-pepperoni-pizza-with-green-pepper-rolls.jpg'
        },
        {
            title: 'Caesar Salad',
            desc: 'Fresh romaine lettuce, parmesan, croutons, and Caesar dressing.',
            price: '$7.00',
            img: '../assets/images/caesar-salad-with-grilled-chicken-breast-parmesan-cherry-tomatoes.jpg'
        }
    ];

    const modal = document.getElementById('orderModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalImage = document.getElementById('modalImage');
    const modalDesc = document.getElementById('modalDesc');
    const modalPrice = document.getElementById('modalPrice');
    const modalQty = document.getElementById('modalQty');

    function openModal(idx) {
        const item = items[idx];
        modalTitle.textContent = item.title;
        modalImage.src = item.img;
        modalDesc.textContent = item.desc;
        modalPrice.textContent = item.price;
        modalQty.value = 1;
        modal.classList.remove('hidden');
    }
    function closeModal() {
        modal.classList.add('hidden');
    }
    // Optional: Prevent form submit default
    modal.querySelector('form').onsubmit = function(e) {
        e.preventDefault();
        // You can add AJAX here to process the order
        closeModal();
        alert('Order placed!');
    };
    </script>
</body>
</html>
