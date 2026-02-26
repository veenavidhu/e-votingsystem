<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
        }

        .project-title {
            color: white;
            font-weight: 800;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
        }

        /* Standardized Button Themes */
        .btn-theme {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-theme:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <a href="/" class="text-decoration-none">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="white"
                            class="bi bi-box-seam" viewBox="0 0 16 16"
                            style="filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.3));">
                            <path
                                d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.708 4.634l2.4 1.258 5.708-2.3zM14.5 5.144L8.5 7.572V15l6-2.428V5.144zM7.5 15V7.572L1.5 5.144V12.572L7.5 15z" />
                        </svg>
                    </div>
                    <h1 class="project-title display-4">E-voting system</h1>
                </a>
            </div>

            <div class="col-11 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>