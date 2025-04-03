@php
    $useBootstrap = $useBootstrap ?? true;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp|Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet">

    @stack('style')

    @if ($useBootstrap)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
            integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('assets/css/meet.css') }}">

    @livewireStyles

    
    <style>
        /* Full-screen animated dark gradient background */
        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(270deg, #0a0f1a, #0c1321, #141e30, #0a0d14);
            background-size: 400% 400%;
            animation: gradientAnimation 12s ease infinite;
            position: relative;
        }

        /* Smooth gradient animation */
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

        /* Wavy Effect Using Pseudo-Elements */
        body::before,
        body::after {
            content: "";
            position: fixed;
            width: 220%;
            height: 220px;
            background: radial-gradient(circle, rgba(100, 100, 255, 0.08) 20%, transparent 80%);
            top: 80%;
            left: -60%;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.6;
            animation: waveMotion 10s ease-in-out infinite;
        }

        /* Second wave for depth */
        body::after {
            top: 85%;
            left: -50%;
            width: 200%;
            height: 200px;
            opacity: 0.4;
            filter: blur(120px);
            animation-duration: 14s;
            animation-delay: 4s;
        }

        /* Deep, slow wave motion */
        @keyframes waveMotion {
            0% {
                transform: translateX(-40%) translateY(0) scaleX(1);
            }

            50% {
                transform: translateX(40%) translateY(15px) scaleX(1.2);
            }

            100% {
                transform: translateX(-40%) translateY(0) scaleX(1);
            }
        }
    </style>
</head>

<body class="dark h-[10px]">

    {{ $slot }}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    @stack('scripts')

    <script>
        const microphoneUrl = "{{ asset('assets/images/microphone-access.svg') }}";
        const videoUrl = "{{ asset('assets/images/camera-access.svg') }}";
    </script>

    <script src="{{ asset('assets/js/meet/main.js') }}" type="module"></script>
    @livewireScripts

    <script>
        window.addEventListener('load', () => {
            Flowbite.initFlowbite();
        })
    </script>
</body>

</html>
