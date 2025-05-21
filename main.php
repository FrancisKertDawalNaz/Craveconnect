<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: customer/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CraveConnect - Login</title>
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
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="./assets/images/owner.jpg" 
                 alt="Restaurant Interior" 
                 class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white p-8">
                    <h1 class="text-4xl font-bold mb-4">CraveConnect</h1>
                    <p class="text-xl">Your favorite local eatery in Siniloan, Laguna</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-primary">Welcome Back!</h1>
                    <p class="text-gray-600 mt-2">Please login to your account</p>
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mb-4 text-red-600 font-semibold"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form class="space-y-6" method="POST" action="auth/login.php">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" />
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-primary hover:text-primary/80">Forgot password?</a>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Sign in
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="register.php" class="font-medium text-primary hover:text-primary/80">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Welcome, <?php echo htmlspecialchars($_SESSION['fullname'] ?? ''); ?>!',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "<?php echo $_SESSION['role'] === 'owner' ? 'owner/dashboard.php' : 'customer/dashboard.php'; ?>";
        });
    </script>
    <?php endif; ?>
</body>
</html>
