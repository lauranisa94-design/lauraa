<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Sistem Absensi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(20px);
                }
            }

            @keyframes pulse-ring {
                0%, 100% {
                    box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
                }
                50% {
                    box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
                }
            }

            .animate-slide-in-left {
                animation: slideInLeft 0.8s ease-out;
            }

            .animate-slide-in-right {
                animation: slideInRight 0.8s ease-out;
            }

            .animate-float {
                animation: float 3.5s ease-in-out infinite;
            }

            .float-delay-1 { animation-delay: 0s; }
            .float-delay-2 { animation-delay: 0.2s; }
            .float-delay-3 { animation-delay: 0.4s; }

            .bg-gradient-auth {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .btn-gradient-auth {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                transition: all 0.3s ease;
            }

            .btn-gradient-auth:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            }

            .btn-gradient-auth:active {
                transform: translateY(0);
            }

            .input-auth {
                transition: all 0.3s ease;
            }

            .input-auth:focus {
                transform: translateY(-2px);
            }

            .input-auth::placeholder {
                color: #9ca3af;
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .text-gradient-purple {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .shadow-auth {
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            }

            @media (max-width: 768px) {
                .hide-on-mobile {
                    display: none;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex">
            <!-- Auth Form - Full Width -->
            <div class="w-full flex items-center justify-center p-6 sm:p-8 animate-slide-in-right">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
