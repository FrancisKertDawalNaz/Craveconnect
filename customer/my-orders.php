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
    <title>CraveConnect - My Orders</title>
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
                <a href="./myorders.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
                    <i class="fas fa-shopping-bag w-6"></i>
                    <span>My Orders</span>
                </a>
                <a href="./loyalty-rewards.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-gift w-6"></i>
                    <span>Loyalty & Rewards</span>
                </a>
                <a href="feedback.html" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-comment-alt w-6"></i>
                    <span>Feedback</span>
                </a>
                <a href="profile.html" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary">
                    <i class="fas fa-user w-6"></i>
                    <span>Profile</span>
                </a>
                <a href="login.html" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-primary mt-4">
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
                    <h2 class="text-xl font-semibold text-gray-800">My Orders</h2>
                    <div class="flex items-center space-x-4">
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Place New Order
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                <!-- Order Status Tabs -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="border-b">
                        <nav class="flex -mb-px">
                            <button class="px-6 py-4 text-primary border-b-2 border-primary font-medium">
                                All Orders
                            </button>
                            <button class="px-6 py-4 text-gray-500 hover:text-gray-700 font-medium">
                                Active
                            </button>
                            <button class="px-6 py-4 text-gray-500 hover:text-gray-700 font-medium">
                                Completed
                            </button>
                            <button class="px-6 py-4 text-gray-500 hover:text-gray-700 font-medium">
                                Cancelled
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-6">
                    <!-- Order 1 -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Order #12345</h3>
                                    <p class="text-sm text-gray-500">March 15, 2024 • 2:30 PM</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Preparing</span>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591" 
                                            alt="Margherita Pizza" 
                                            class="w-16 h-16 rounded-lg object-cover">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Margherita Pizza</h4>
                                            <p class="text-sm text-gray-500">Regular • Extra Cheese</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">$12.99</p>
                                        <p class="text-sm text-gray-500">Qty: 1</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87" 
                                            alt="Tiramisu" 
                                            class="w-16 h-16 rounded-lg object-cover">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Tiramisu</h4>
                                            <p class="text-sm text-gray-500">Classic</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">$6.99</p>
                                        <p class="text-sm text-gray-500">Qty: 1</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Subtotal</span>
                                    <span class="text-sm font-medium text-gray-900">$19.98</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Delivery Fee</span>
                                    <span class="text-sm font-medium text-gray-900">$2.99</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Tax</span>
                                    <span class="text-sm font-medium text-gray-900">$1.83</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-base font-medium text-gray-900">$24.80</span>
                                </div>
                            </div>

                            <!-- Order Actions -->
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        Track Order
                                    </button>
                                    <button onclick="showReceiptModal('12345')" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                        <i class="fas fa-receipt mr-1"></i>
                                        View Receipt
                                    </button>
                                </div>
                                <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    <i class="fas fa-times mr-1"></i>
                                    Cancel Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order 2 -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Order #12344</h3>
                                    <p class="text-sm text-gray-500">March 14, 2024 • 7:15 PM</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">Delivered</span>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38" 
                                            alt="Pepperoni Pizza" 
                                            class="w-16 h-16 rounded-lg object-cover">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Pepperoni Pizza</h4>
                                            <p class="text-sm text-gray-500">Large • Extra Pepperoni</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">$15.99</p>
                                        <p class="text-sm text-gray-500">Qty: 1</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Subtotal</span>
                                    <span class="text-sm font-medium text-gray-900">$15.99</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Delivery Fee</span>
                                    <span class="text-sm font-medium text-gray-900">$2.99</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Tax</span>
                                    <span class="text-sm font-medium text-gray-900">$1.47</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-base font-medium text-gray-900">$20.45</span>
                                </div>
                            </div>

                            <!-- Order Actions -->
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <button onclick="showReceiptModal('12344')" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                        <i class="fas fa-receipt mr-1"></i>
                                        View Receipt
                                    </button>
                                    <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                        <i class="fas fa-redo mr-1"></i>
                                        Reorder
                                    </button>
                                </div>
                                <button class="text-primary hover:text-primary/80 text-sm font-medium">
                                    <i class="fas fa-star mr-1"></i>
                                    Rate Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Track Order Modal -->
    <div id="trackOrderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">Track Order #<span id="trackOrderNumber"></span></h3>
                    <button onclick="closeTrackOrderModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Order Timeline -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium">Order Placed</p>
                            <p class="text-sm text-gray-500">March 15, 2024 • 2:30 PM</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium">Preparing</p>
                            <p class="text-sm text-gray-500">March 15, 2024 • 2:35 PM</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-500">Completed</p>
                            <p class="text-sm text-gray-500">Estimated: 2:45 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Estimated Delivery -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Estimated Delivery</p>
                            <p class="font-medium">2:45 PM</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Time Remaining</p>
                            <p class="font-medium text-primary">10 minutes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reorder Modal -->
    <div id="reorderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">Reorder #<span id="reorderNumber"></span></h3>
                    <button onclick="closeReorderModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Order Items -->
                <div class="space-y-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38" alt="Pizza" class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <p class="font-medium">Margherita Pizza</p>
                                <p class="text-sm text-gray-500">$12.99</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="w-8 text-center">1</span>
                            <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1608030281513-45ef5d6a2a26" alt="Salad" class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <p class="font-medium">Caesar Salad</p>
                                <p class="text-sm text-gray-500">$8.99</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="w-8 text-center">1</span>
                            <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t pt-4 mb-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span>$21.98</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Delivery Fee</span>
                            <span>$2.99</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tax</span>
                            <span>$1.99</span>
                        </div>
                        <div class="flex justify-between font-medium pt-2 border-t">
                            <span>Total</span>
                            <span class="text-primary">$26.96</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary/90 font-medium">
                    Place Order
                </button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md mx-4 max-h-[90vh] flex flex-col">
            <!-- Modal Header - Fixed -->
            <div class="p-6 border-b flex-shrink-0">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-semibold">Order Receipt #<span id="receiptOrderNumber"></span></h3>
                    <div class="flex items-center space-x-4">
                        <button onclick="printReceipt()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-print"></i>
                        </button>
                        <button onclick="closeReceiptModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Content - Scrollable -->
            <div class="p-6 overflow-y-auto">
                <!-- Restaurant Info -->
                <div class="text-center mb-6">
                    <h4 class="text-lg font-semibold">Pizza Place</h4>
                    <p class="text-sm text-gray-500">123 Main Street, City, State 12345</p>
                    <p class="text-sm text-gray-500">Phone: (555) 123-4567</p>
                </div>

                <!-- Order Info -->
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Order Date</span>
                        <span id="receiptOrderDate">March 15, 2024</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Order Time</span>
                        <span id="receiptOrderTime">2:30 PM</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Order Type</span>
                        <span id="receiptOrderType">Delivery</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Payment Method</span>
                        <span id="receiptPaymentMethod">Credit Card</span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-b py-4 mb-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">Margherita Pizza</p>
                                <p class="text-sm text-gray-500">Regular • Extra Cheese</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">$12.99</p>
                                <p class="text-sm text-gray-500">Qty: 1</p>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">Tiramisu</p>
                                <p class="text-sm text-gray-500">Classic</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">$6.99</p>
                                <p class="text-sm text-gray-500">Qty: 1</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span>$19.98</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Delivery Fee</span>
                        <span>$2.99</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax</span>
                        <span>$1.83</span>
                    </div>
                    <div class="flex justify-between font-medium pt-2 border-t">
                        <span>Total</span>
                        <span class="text-primary">$24.80</span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="border-t pt-4">
                    <h4 class="text-sm font-medium mb-2">Delivery Address</h4>
                    <p class="text-sm text-gray-600">John Doe</p>
                    <p class="text-sm text-gray-600">456 Customer Street</p>
                    <p class="text-sm text-gray-600">Apt 789, City, State 12345</p>
                    <p class="text-sm text-gray-600">Phone: (555) 987-6543</p>
                </div>

                <!-- Thank You Message -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">Thank you for your order!</p>
                    <p class="text-sm text-gray-500">Please rate your experience</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Place New Order Modal -->
    <div id="placeOrderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-semibold">Place New Order</h3>
                    <button onclick="closePlaceOrderModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form>
                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Select Item</label>
                        <select class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Choose an item --</option>
                            <option>Classic Burger</option>
                            <option>Pepperoni Pizza</option>
                            <option>Caesar Salad</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Quantity</label>
                        <input type="number" min="1" value="1" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary/90 font-medium">Place Order</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTrackOrderModal(orderNumber) {
            document.getElementById('trackOrderNumber').textContent = orderNumber;
            document.getElementById('trackOrderModal').classList.remove('hidden');
            document.getElementById('trackOrderModal').classList.add('flex');
        }

        function closeTrackOrderModal() {
            document.getElementById('trackOrderModal').classList.add('hidden');
            document.getElementById('trackOrderModal').classList.remove('flex');
        }

        function showReorderModal(orderNumber) {
            document.getElementById('reorderNumber').textContent = orderNumber;
            document.getElementById('reorderModal').classList.remove('hidden');
            document.getElementById('reorderModal').classList.add('flex');
        }

        function closeReorderModal() {
            document.getElementById('reorderModal').classList.add('hidden');
            document.getElementById('reorderModal').classList.remove('flex');
        }

        function showReceiptModal(orderNumber) {
            document.getElementById('receiptOrderNumber').textContent = orderNumber;
            document.getElementById('receiptModal').classList.remove('hidden');
            document.getElementById('receiptModal').classList.add('flex');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
            document.getElementById('receiptModal').classList.remove('flex');
        }

        // Place New Order Modal logic
        const placeOrderModal = document.getElementById('placeOrderModal');
        function openPlaceOrderModal() {
            placeOrderModal.classList.remove('hidden');
            placeOrderModal.classList.add('flex');
        }
        function closePlaceOrderModal() {
            placeOrderModal.classList.add('hidden');
            placeOrderModal.classList.remove('flex');
        }
        // Attach to Place New Order button
        const placeOrderBtn = document.querySelector('button.bg-primary.text-white');
        if (placeOrderBtn) {
            placeOrderBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openPlaceOrderModal();
            });
        }
        // Optional: Prevent form submit default
        placeOrderModal.querySelector('form').onsubmit = function(e) {
            e.preventDefault();
            closePlaceOrderModal();
            alert('Order placed!');
        };

        function printReceipt() {
            const receiptContent = document.getElementById('receiptModal').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Order Receipt</title>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                        <script src="https://cdn.tailwindcss.com"><\/script>
                        <style>
                            @media print {
                                body { padding: 20px; }
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        ${receiptContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>