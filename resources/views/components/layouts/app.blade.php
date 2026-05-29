<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PDF Chatbot') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .neon-grid {
            background-image:
                radial-gradient(circle at 20% 20%, rgba(34, 211, 238, 0.16), transparent 30%),
                radial-gradient(circle at 80% 0%, rgba(168, 85, 247, 0.2), transparent 25%),
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: auto, auto, 28px 28px, 28px 28px;
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 0 0 1px rgba(99, 102, 241, 0.2), 0 0 24px rgba(56, 189, 248, 0.15);
        }
    </style>
    @livewireStyles
</head>
<body class="neon-grid min-h-screen bg-slate-950 text-slate-100">
    {{ $slot }}

    @livewireScripts
</body>
</html>
