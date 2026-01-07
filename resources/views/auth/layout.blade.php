<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') - 3RAJO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Cinzel', serif; text-transform: uppercase; letter-spacing: 0.05em; font-size: 1.5rem; margin-bottom: 0.5rem; text-align: center; }
        
        /* Shim Bootstrap into Minimal Design */
        .form-control {
            width: 100%;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            background: #fafafa;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: black;
            background: white;
        }
        
        .btn-primary {
            display: block;
            width: 100%;
            background-color: black;
            color: white;
            text-align: center;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.75rem;
            border: 1px solid black;
            transition: all 0.3s;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: white;
            color: black;
        }
        
        .alert-danger {
            color: #ef4444;
            background-color: #fef2f2;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.75rem;
        }
        
        .mb-3 { margin-bottom: 1.5rem; }
        .text-muted { color: #9ca3af; font-size: 0.75rem; text-align: center; margin-bottom: 2rem; display: block; }
        .form-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; margin-bottom: 0.5rem; display: block; color: #374151; }
        
        .auth-link { margin-top: 2rem; text-align: center; font-size: 0.75rem; color: #6b7280; }
        .auth-link a { text-decoration: underline; color: black; }
        
        .invalid-feedback { color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem; display: block; }
        
        /* Checkbox styling */
        .form-check { display: flex; align-items: center; gap: 0.5rem; }
        .form-check-input { width: 1rem; height: 1rem; accent-color: black; }
        .form-check-label { font-size: 0.75rem; margin: 0; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-white">
    <div class="w-full max-w-md p-8 md:p-12">
        <div class="text-center mb-12">
            <a href="/" class="text-4xl font-serif font-bold tracking-tighter">3RAJO</a>
        </div>
        @yield('content')
    </div>
</body>
</html>
