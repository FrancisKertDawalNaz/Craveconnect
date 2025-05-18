<?php
// register.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <!-- Left side - Image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                alt="Restaurant Food" 
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white p-8">
                    <h1 class="text-4xl font-bold mb-4">Join CraveConnect</h1>
                    <p class="text-xl">Experience the best dining in Siniloan, Laguna</p>
                </div>
            </div>
        </div>

        <!-- Right side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-primary">Create Account</h1>
                    <p class="text-gray-600 mt-2">Join our community of food lovers</p>
                </div>
                
                <form action="auth/register.php" method="POST" class="space-y-4">
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-primary hover:text-primary/80">Terms and Conditions</a>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="main.php" class="font-medium text-primary hover:text-primary/80">Sign in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
<script>
    Swal.fire({
        title: 'Account Created!',
        text: 'You have successfully registered.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
</script>
<?php endif; ?>

</body>
</html>
