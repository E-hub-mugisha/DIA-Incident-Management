<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | VigilantEye Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        /* Background image with overlay */
        body {
            background: url('assets/still.jpg') no-repeat center center/cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 37, 17, 0.7); /* Dark green overlay */
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1; /* Place content above overlay */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.95); /* Slight transparency for card */
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
