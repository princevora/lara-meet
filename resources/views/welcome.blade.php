<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Meeting Site</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center p-4">
            <h1 class="text-3xl font-bold text-blue-600">MeetingSite</h1>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="#" class="text-gray-700 hover:text-blue-600 transition duration-200">Home</a></li>
                    <li><a href="#" class="text-gray-700 hover:text-blue-600 transition duration-200">Features</a></li>
                    <li><a href="#" class="text-gray-700 hover:text-blue-600 transition duration-200">Pricing</a></li>
                    <li><a href="#" class="text-gray-700 hover:text-blue-600 transition duration-200">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold">Connect with Anyone, Anywhere</h2>
            <p class="mt-4 text-lg">Join or schedule meetings effortlessly with MeetingSite.</p>
            <div class="mt-8">
                <input type="text" placeholder="Enter Meeting Code" class="p-3 w-1/3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300">
                <button class="ml-4 p-3 bg-white text-blue-600 rounded-md hover:bg-gray-200 transition duration-200">Join Meeting</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white mt-10 py-4 shadow">
        <div class="container mx-auto text-center">
            <p class="text-gray-600">&copy; 2024 MeetingSite. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
