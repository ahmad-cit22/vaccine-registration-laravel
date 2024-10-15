<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetVacc | @yield('title', 'A Vaccine Registration System')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @include('includes.styles')

    <script defer>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>

<body class="min-h-screen flex flex-col justify-between">

    <!-- Header -->
    @include('partials.header')

    <!-- Flash Messages -->
    @include('partials.notifications')

    <!-- Main Section -->
    @yield('content')

    <!-- Modals -->
    @stack('modals')

    <!-- Footer -->
    @include('partials.footer')

    @include('includes.scripts')
</body>

</html>
