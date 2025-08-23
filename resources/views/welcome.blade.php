<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | VigilantEye Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #002511, #a2b9adff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        .welcome-card {
            background: #fff;
            color: #002511;
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            padding: 2rem;
            max-width: 650px;
            text-align: center;
        }

        .welcome-card h1 {
            font-weight: bold;
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: #002511;
        }

        .welcome-card p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .btn-custom {
            background-color: #002511;
            border: none;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #014d27;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-card mx-auto">
            <h1>Welcome to the VigilantEye Management Platform</h1>
            <p>Track, assign, mitigate, and resolve incidents with ease. Stay updated with real-time notifications and reports.</p>

            <div class="d-flex justify-content-center gap-3">
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-custom">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Register</a>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
