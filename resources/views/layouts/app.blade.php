<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://i.pinimg.com/736x/55/dc/f7/55dcf734bd22f4277d10444622b2b825.jpg" type="image/x-icon">

    <title>{{ config('app.name', 'Inventory') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Scripts & Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        const savedPrimaryColor = localStorage.getItem('primaryColor') || '#0e7ea3';
        document.documentElement.style.setProperty('--primary-color', savedPrimaryColor);

        window.setPrimaryColor = function (color) {
            document.documentElement.style.setProperty('--primary-color', color);
            localStorage.setItem('primaryColor', color);
        };

        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.classList.toggle('dark', savedTheme === 'dark');

        window.toggleTheme = function () {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: isDark }));
        };
    </script>

    <style>
        :root { --primary-color: #0e7ea3; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .bg-primary\/5 { background-color: color-mix(in srgb, var(--primary-color) 5%, transparent) !important; }
        .bg-primary\/10 { background-color: color-mix(in srgb, var(--primary-color) 10%, transparent) !important; }
        .bg-primary\/20 { background-color: color-mix(in srgb, var(--primary-color) 20%, transparent) !important; }
        .hover\:bg-primary\/10:hover { background-color: color-mix(in srgb, var(--primary-color) 10%, transparent) !important; }
        .hover\:bg-primary\/20:hover { background-color: color-mix(in srgb, var(--primary-color) 20%, transparent) !important; }
        .hover\:bg-primary-700:hover,
        .hover\:bg-primary\/90:hover { background-color: color-mix(in srgb, var(--primary-color) 85%, black) !important; }
        .hover\:text-primary:hover { color: var(--primary-color) !important; }
        .focus\:border-primary:focus { border-color: var(--primary-color) !important; }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary-color) !important; }
        .focus\:ring-primary\/20:focus { --tw-ring-color: color-mix(in srgb, var(--primary-color) 20%, transparent) !important; }
        .focus\:ring-primary-200:focus { --tw-ring-color: color-mix(in srgb, var(--primary-color) 25%, transparent) !important; }
        .peer:checked ~ .peer-checked\:bg-primary { background-color: var(--primary-color) !important; }
        
        .dark body,
        .dark main,
        .dark .bg-gray-50,
        .dark .bg-neutral-primary-soft { background-color: #0f172a !important; color: #e2e8f0; }
        .dark nav,
        .dark .bg-white { background-color: #1e293b !important; }
        .dark .text-heading,
        .dark .text-slate-800,
        .dark .text-gray-800,
        .dark .text-gray-700,
        .dark .text-slate-700 { color: #f8fafc !important; }
        .dark .text-body,
        .dark .text-gray-500,
        .dark .text-slate-600 { color: #cbd5e1 !important; }
        .dark .border-default,
        .dark .border-gray-200,
        .dark .border-slate-200 { border-color: #475569 !important; }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Page Navigation -->
    @include('layouts.navigation')

    <!-- Page Sidebar -->
    @include('layouts.sidebar')
   
    <!-- Page Content -->
    <div class="p-4 sm:ml-64 mt-14 min-h-[calc(100dvh-56px)]">
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Optional: Display User Role Badge inside body if needed globally -->
    @if(auth()->check())
        <div class="fixed bottom-4 right-4 z-50">
            <span class="px-2.5 py-1 text-xs font-bold rounded-full shadow-md
                {{ strtolower(auth()->user()->role) === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-350' }}">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>
    @endif

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    
    <!-- Flatpickr JS & Khmer Locale -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/km.js"></script>
</body>

</html>