<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    @stack('style')

    <script src="https://cdn.tailwindcss.com/"></script>
    <script src="{{ asset('assets/js/meet.js') }}" type="module"></script>
    <script src="{{ asset('assets/js/class/permissions/permision.js') }}" type="module"></script>
</head>

<body>

    {{ $slot }}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    @stack('scripts')
</body>

</html>
