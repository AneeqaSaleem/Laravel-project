<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- ✅ Bootstrap CSS for UI design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Bootstrap Icons for using iconography (email, lock, shield etc.) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ✅ Background gradient */
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
        }

        /* ✅ Card design with rounded corners + shadow + animation */
        .card {
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.12);
            animation: fadeInUp 0.8s;
        }

        /* ✅ Card animation (fade + slide up) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }

        /* ✅ Shield lock icon styling (animated swing) */
        .login-anim-icon {
            font-size: 60px;
            color: #267abeff;
            animation: swing 1.5s infinite alternate;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* ✅ Swing animation for icon */
        @keyframes swing {
            0% { transform: rotate(-10deg);}
            100% { transform: rotate(10deg);}
        }

        /* ✅ Input group prefix styling (icons background) */
        .input-group-text {
            background: #1c1aaeff;
            color: #fff;
            border: none;
        }

        /* ✅ Input focus effect (blue shadow + border highlight) */
        .form-control:focus {
            box-shadow: 0 0 0 2px #7c6bc433;
            border-color: #2f0e92ff;
        }

        /* ✅ Primary button styling */
        .btn-primary {
            background: #4d18e0ff;
            border: none;
            font-weight: 500;
            letter-spacing: 1px;
        }
        .btn-primary:hover {
            background: #2216a8ff;
        }

        /* ✅ Link button styling (register link) */
        .btn-link {
            color: #0e1e98ff;
            text-decoration: none;
        }
        .btn-link:hover {
            text-decoration: underline;
            color: #4218c0ff;
        }

        /* ✅ Card header design */
        .card-header {
            background: #0a0c83ff;
            color: #fff;
            border-radius: 18px 18px 0 0; /* Rounded top only */
        }

        /* ✅ Error alert message styling */
        .alert-danger {
            font-size: 15px;
            padding: 6px 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- ✅ Login Card -->
    <div class="card shadow-lg" style="max-width:400px; margin:auto;">

        <!-- ✅ Card Header with animated shield icon -->
        <div class="card-header text-center">
            <span class="login-anim-icon"><i class="bi bi-shield-lock-fill"></i></span>
            <h3 class="mb-0 mt-2">Login</h3>
        </div>

        <!-- ✅ Card Body -->
        <div class="card-body">
            
            <!-- ✅ Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf <!-- ✅ Laravel CSRF protection -->

                <!-- Email Input -->
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>

                <!-- Password Input -->
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <!-- ✅ Error Handling (if invalid email entered) -->
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <!-- ✅ Submit and Register Buttons -->
                <div class="d-grid gap-2">
                    <!-- Login Button -->
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>

                    <!-- Register Redirect -->
                    <a href="{{ route('register.show') }}" class="btn btn-link">
                        <i class="bi bi-person-plus"></i> Create new account
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
