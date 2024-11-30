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
                    - Profile</span>
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                Effortlessly join or host virtual meetings with ease and style.
            </p>
        </header>

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

                <!-- Create Meeting Section -->
                <div class="text-center">
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">Create Meeting <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownInformation"
                        class="z-10 hidden divide-y rounded-lg shadow w-44 bg-gray-900 divide-gray-600">
                        <div class="px-4 py-3 text-sm text-white">
                            <div>Lara - Meet</div>
                            <div class="font-medium text-wrap">Create Meeting</div>
                        </div>
                        <ul class="py-2 bg-gray-900 text-sm text-gray-200"
                            aria-labelledby="dropdownInformationButton">
                            <li class="bg-gray-900">
                                <a href="#"
                                    class="px-4 py-2 gap-2 bg-gray-900 hover:bg-gray-900 hover:text-white flex">
                                    <span class="material-symbols-outlined">
                                        add
                                    </span>
                                    <span>
                                        Start Meeting
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-12 text-center text-gray-500 text-sm">
            <p>
                Powered by <a href="#" class="text-purple-400 hover:underline">Lara - Profile</a>. All rights
                reserved.
            </p>
        </footer>
    </div>
</body>

</html>
