<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- ... (meta, title, Fonts, Scripts) ... --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" 
      style="background-color: #FEF8F0; 
             background-image: 
                linear-gradient(90deg, rgba(224, 212, 192, 0.2) 1px, transparent 1px),
                linear-gradient(rgba(224, 212, 192, 0.2) 1px, transparent 1px);
             background-size: 3px 3px;">

    {{-- ログインフォームなど --}}
    <main class="w-full max-w-[390px] mx-auto min-h-screen flex flex-col items-center justify-center px-4">
        {{ $slot }}
    </main>

</body>
</html>