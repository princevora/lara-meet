<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing - Lara Meet</title>

    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp|Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Live animated gradient background */
        body {
            background: linear-gradient(270deg, #1e293b, #0f172a, #2d3748, #1a202c);
            background-size: 800% 800%;
            animation: gradientAnimation 15s ease infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body class="text-white min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-4xl p-6">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-5xl font-extrabold mb-4">
                Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-300 to-purple-400">Lara
                    - Meet</span>
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                Effortlessly join or host virtual meetings with ease and style.
            </p>
        </header>

        @auth
            <!-- Main Content -->
            <main>
                <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 rounded-2xl shadow-2xl p-8">
                    <!-- Join Meeting Section -->
                    <div class="mb-8">
                        <h2
                            class="text-3xl text-transparent font-bold bg-clip-text bg-gradient-to-r from-gray-300 to-purple-400 mb-6 text-center">
                            Join a Meeting</h2>
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <input type="text" placeholder="Enter meeting code"
                                class="w-full px-5 py-3 rounded-lg bg-gray-700 text-white text-lg focus:ring-4 focus:ring-purple-400 outline-none transition">
                            <button
                                class="px-8 py-3 text-lg font-semibold  bg-blue-800 text-white rounded-lg shadow-lg hover:scale-105 transform transition focus:ring-4 focus:ring-blue-500 focus:outline-none">
                                Join
                            </button>

                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-10">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-800 px-4 text-gray-400">OR</span>
                        </div>
                    </div>

                    <livewire:user.home.start-meeting lazy />
                </div>
            </main>
        @else
            <div class="max-w-sm p-6 mx-auto border rounded-lg shadow-sm border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-video2" viewBox="0 0 16 16">
                    <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    <path
                        d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM1 3a1 1 0 0 1 1-1h2v2H1zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3zm-4-2h3v2H2a1 1 0 0 1-1-1zm3-1H1V8h3zm0-3H1V5h3z" />
                </svg>
                <a href="#">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-white">Not Logged In Yet?</h5>
                </a>
                <p class="mb-3 font-normal text-gray-400">Login to access the Lara Meet App</p>
                <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                    Login Here..
                    <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                    </svg>
                </a>
            </div>

        @endauth

        <!-- Footer -->
        <footer class="mt-12 text-center text-gray-500 text-sm">
            <p>
                Powered by <a href="#" class="text-purple-400 hover:underline">Lara - Meet</a>. All rights
                reserved.
            </p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('flowbiteInit', () => {
                // Initialize Flowbite components that need JavaScript re-initialization
                setTimeout(() => {
                    Flowbite.initFlowbite();
                }, 100);
            });
        })
    </script>
</body>

</html>
