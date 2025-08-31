<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- ✅ Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Bootstrap Icons for using icons in form (like user, lock, camera etc.) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ✅ Body styling: Gradient background + default font */
        body {
            background: linear-gradient(to right, #e3f2fd, #f1f8e9);
            font-family: 'Segoe UI', sans-serif;
        }

        /* ✅ Card design with rounded corners */
        .card {
            border-radius: 20px;
            overflow: hidden;
        }

        /* ✅ Card header background color */
        .card-header {
            background: #1565c0;
        }

        /* ✅ Profile picture container */
        .profile-upload {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto 20px auto; /* Center + margin bottom */
        }

        /* ✅ Uploaded image styling (circle, border, shadow) */
        .profile-upload img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1565c0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            display: none; /* By default hidden until user uploads */
            position: absolute;
            top: 0;
            left: 0;
        }

        /* ✅ File input hidden (we only use label as upload button) */
        .profile-upload input {
            display: none;
        }

        /* ✅ Camera icon (upload trigger button) styling */
        .profile-upload label {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #1565c0;
            color: white;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
            border: 2px solid #fff;
            font-size: 18px;
            z-index: 2;
        }

        /* ✅ Placeholder shown before image upload */
        .profile-placeholder {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: #e0e0e0;
            border: 4px dashed #1565c0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #1565c0;
            font-weight: 500;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            text-align: center;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-lg">
        <!-- ✅ Card Header -->
        <div class="card-header text-white text-center">
            <h3 class="mb-0"><i class="bi bi-person-plus-fill"></i> Register</h3>
        </div>
        <div class="card-body">

            <!-- ✅ Registration Form Start -->
            <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate>
                @csrf <!-- ✅ Laravel CSRF protection -->

                <!-- ✅ Profile Picture Upload Section -->
                <div class="text-center mt-4 mb-4">
                    <div class="profile-upload">
                        <!-- Placeholder (shown until user uploads image) -->
                        <div id="profilePlaceholder" class="profile-placeholder">
                            Add Photo<br>Here
                        </div>
                        <!-- Preview uploaded image -->
                        <img id="previewImage" src="" alt="Profile" class="shadow">
                        <!-- Hidden file input (accept only images) -->
                        <input type="file" name="profile_picture" id="profileInput" accept="image/*" required>
                        <!-- Camera icon as clickable button for uploading -->
                        <label for="profileInput"><i class="bi bi-camera-fill"></i></label>
                    </div>
                    <!-- Error message if user does not upload profile picture -->
                    <div class="text-danger small" id="profileError" style="display:none;">Profile picture is required.</div>
                </div>

                <!-- ✅ Full Name Field -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                </div>

                <!-- ✅ Email Field -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" class="form-control" name="email" id="emailInput" placeholder="Email Address" required>
                </div>
                <!-- Custom email validation message (only gmail allowed) -->
                <div class="text-danger small" id="emailError" style="display:none;">Email must end with @gmail.com</div>

                <!-- ✅ Password Field -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-primary text-white"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Password" required>
                </div>
                <!-- Custom password validation message (min 8 chars) -->
                <div class="text-danger small" id="passwordError" style="display:none;">Password must be at least 8 characters.</div>

                <!-- ✅ Confirm Password Field -->
                <div class="mb-3 input-group">
                    <span class="input-group-text bg-primary text-white"><i class="bi bi-shield-lock-fill"></i></span>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <!-- ✅ Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill"></i> Register
                    </button>
                </div>

                <!-- ✅ Login Redirect Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('login.show') }}" class="text-decoration-none">
                        <i class="bi bi-box-arrow-in-right"></i> Already have an account? Login
                    </a>
                </div>
            </form>
            <!-- ✅ Registration Form End -->

        </div>
    </div>
</div>

<script>
    /* ===========================
       ✅ JAVASCRIPT FUNCTIONALITY
       =========================== */

    // Profile Image Preview Functionality
    const profileInput = document.getElementById("profileInput");
    const previewImage = document.getElementById("previewImage");
    const placeholder = document.getElementById("profilePlaceholder");
    const profileError = document.getElementById("profileError");

    profileInput.addEventListener("change", function(event){
        const [file] = event.target.files;
        if(file){
            // ✅ Show selected image in preview
            previewImage.src = URL.createObjectURL(file);
            previewImage.style.display = "block";
            placeholder.style.display = "none";
            profileError.style.display = "none";
        } else {
            // ✅ If no file, show placeholder again
            previewImage.style.display = "none";
            placeholder.style.display = "flex";
        }
    });

    // ✅ Form Validation on Submit
    document.getElementById("registerForm").addEventListener("submit", function(e){
        let valid = true;

        // Profile Picture Required Validation
        if(!profileInput.files.length){
            profileError.style.display = "block";
            valid = false;
        }

        // Email Validation (must end with @gmail.com)
        const email = document.getElementById("emailInput").value;
        if(!email.endsWith("@gmail.com")){
            document.getElementById("emailError").style.display = "block";
            valid = false;
        } else {
            document.getElementById("emailError").style.display = "none";
        }

        // Password Length Validation (min 8 chars)
        const password = document.getElementById("passwordInput").value;
        if(password.length < 8){
            document.getElementById("passwordError").style.display = "block";
            valid = false;
        } else {
            document.getElementById("passwordError").style.display = "none";
        }

        // Prevent form submit if validations fail
        if(!valid){
            e.preventDefault();
        }
    });
</script>

</body>
</html>
