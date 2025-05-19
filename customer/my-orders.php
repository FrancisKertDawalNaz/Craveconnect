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
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                <a href="./my-orders.php" class="flex items-center px-4 py-3 text-primary bg-gray-100">
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
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">My Orders</h2>
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
                        </nav>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-6">
                    <?php
                    // Fetch orders for this user from the database
                    require_once '../auth/connection.php';
                    $userId = $_SESSION['user_id'];
                    $orders = [];
                    $sql = "SELECT id, item_name, quantity, total, order_status, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param('i', $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $orders[] = $row;
                        }
                        $stmt->close();
                    }
                    ?>

                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <div class="bg-white rounded-lg shadow">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">Order #<?php echo $order['id']; ?></h3>
                                            <p class="text-sm text-gray-500"><?php echo date('F d, Y • h:i A', strtotime($order['order_date'])); ?></p>
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
                                    
                                    <!-- Order Items (simple version, since only item_name/quantity/total in DB) -->
                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($order['item_name']); ?></h4>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900"><?php echo number_format($order['total'], 2); ?></p>
                                                <p class="text-sm text-gray-500">Qty: <?php echo $order['quantity']; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="border-t pt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Total</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo number_format($order['total'], 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-gray-400 text-center">No orders found.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Removed Place New Order Modal and related JS -->
    
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