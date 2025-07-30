<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DIA Incident Management') }}</title>

    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />

    <!-- Custom Olive Theme -->
    <style>
        body {
            background: #002511;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .brand-title {
            color: #002511;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .brand-subtitle {
            color: #002511;
        }

        .card-custom {
            background: #F0F2F7;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            color: #fff;
            /* Optional: for better contrast on dark background */
        }

        .card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .form-label {
        color: #002511;
        font-weight: 600;
    }

        .btn-olive {
            background-color: #002511;
            color: white;
        }

        .btn-olive:hover {
            background-color: #6B8E23;
        }

        .btn-custom {
            background-color: #002511;
            color: #fff;
            border: 1px solid #002511;
            transition: 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #ffffff;
            color: #002511;
            border: 1px solid #002511;
        }
        .custom-input {
        border: none;
        border-bottom: 1px solid #002511;
        border-radius: 0;
        background-color: #fff;
        color: #002511;
        box-shadow: none;
    }

    .custom-input:focus {
        border-bottom: 1px solid #002511;
        box-shadow: none;
        outline: none;
        background-color: #f8f9fa;
    }
    .text-dark-green {
        color: #002511;
        font-weight: 600;
    }

    .custom-checkbox:checked {
        background-color: #002511;
        border-color: #002511;
    }

    .custom-checkbox:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 37, 17, 0.25);
    }
    </style>
</head>

<body>
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-custom p-4">
                        <div class="text-center mb-3">
                            <a href="/" class="text-decoration-none">
                                <div class="brand-title">DIA Incident Management</div>
                            </a>
                            <div class="brand-subtitle">Monitoring and Mitigation System</div>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>

</html>