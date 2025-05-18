<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveConnect - Restaurant Registration</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                alt="Restaurant Kitchen" 
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white p-8">
                    <h1 class="text-4xl font-bold mb-4">Join CraveConnect</h1>
                    <p class="text-lg">Start managing your restaurant's online presence today</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 overflow-y-auto">
            <div class="max-w-2xl mx-auto px-4 py-8">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-primary">CraveConnect</h1>
                    <p class="text-gray-600 mt-2">Restaurant Owner Registration</p>
                </div>

                <!-- Registration Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Your Restaurant Account</h2>
                    
                    <form class="space-y-6" method="POST" action="./auth/register.php">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-700">Basic Information</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="fullname" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter your full name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter email address">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter phone number">
                            </div>
                        </div>

                        <!-- Restaurant Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-700">Restaurant Information</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant Name</label>
                                <input type="text" name="restaurant_name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter restaurant name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant Address</label>
                                <input type="text" name="restaurant_address" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter restaurant address">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cuisine Type</label>
                                <select name="cuisine_type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select cuisine type</option>
                                    <option value="italian">Italian</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="indian">Indian</option>
                                    <option value="mexican">Mexican</option>
                                    <option value="american">American</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Account Security -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-700">Account Security</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Create a password">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" name="confirm_password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Confirm your password">
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" required
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-primary hover:text-primary/80">Terms and Conditions</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                            class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary/90 font-medium transition duration-200">
                            Create Account
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="./restaurant-login.php" class="text-primary hover:text-primary/80 font-medium">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>