<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Sets character encoding to UTF-8 so all symbols/languages display correctly -->
  <title>Product Inventory</title>

  <!-- ✅ Bootstrap CSS for responsive grid, buttons, tables, etc. -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Bootstrap Icons for using icons like pencil, trash, lock, etc. -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- ✅ jQuery (used for small JS helpers like toggle sidebar, delete confirm) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- ✅ Bootstrap JS bundle (includes Popper.js for modals, dropdowns, etc.) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      overflow-x: hidden; /* Prevent horizontal scroll */
      background: #f8f9fa; /* Light gray background */
    }
    /* ================= Sidebar Styles ================= */
    .sidebar {
      position: fixed; /* Sidebar is always fixed on the left */
      top: 0; left: -260px; /* Initially hidden (moved left) */
      width: 260px;
      height: 100%;
      background: #09bc50ff; /* Green background */
      color: white;
      transition: all 0.3s ease; /* Smooth sliding animation */
      padding: 20px;
      z-index: 1050; /* Stays above content but below hamburger */
    }
    .sidebar.active { left: 0; } /* When "active" class is added, sidebar slides in */

    /* ✅ Profile picture inside sidebar */
    .sidebar .profile-pic {
      width: 100px; height: 100px;
      object-fit: cover; border-radius: 50%; /* Circle shape */
      margin: 0 auto 10px auto; display: block;
      border: 3px solid #ffc107; /* Yellow border */
    }
    .sidebar h4, .sidebar p { text-align: center; margin: 5px 0; }

    /* ✅ Navigation links inside sidebar */
    .sidebar .nav-link {
      color: #ffc107; /* Yellow by default */
      display: flex; align-items: center; gap: 10px; /* Icon + text */
      margin: 10px 0; font-size: 15px;
    }
    .sidebar .nav-link:hover { color: #fff; } /* Hover effect changes to white */

    /* ================= Overlay Styles ================= */
    .overlay {
      position: fixed; top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); /* Transparent black background */
      display: none; z-index: 1040;
    }
    .overlay.active { display: block; } /* Shown when sidebar opens */

    /* ================= Hamburger Icon ================= */
    .hamburger {
      position: fixed;
      top: 15px; left: 15px; /* Top-left corner */
      font-size: 28px; cursor: pointer;
      z-index: 1100; color: #212529; /* Above everything */
    }

    /* ================= Main Content ================= */
    .content {
      max-width: 1100px; /* Limit content width */
      margin: 30px auto;
      padding: 20px;
    }
  </style>
</head>
<body>

  <!-- ================= Hamburger Button ================= -->
  <!-- Clicking this opens/closes the sidebar -->
  <div class="hamburger"><i class="bi bi-list"></i></div>

  <!-- ================= Sidebar Menu ================= -->
  <div class="sidebar">
    <div class="text-center mb-3">
      <!-- ✅ Show profile picture if uploaded, otherwise show placeholder -->
      @if(Auth::user()->profile_picture)
        <img src="{{ asset('profiles/' . Auth::user()->profile_picture) }}" alt="Profile" class="profile-pic">
      @else
        <img src="https://via.placeholder.com/100" alt="Profile" class="profile-pic">
      @endif

      <!-- ✅ Show logged-in user's name and email -->
      <h4>{{ Auth::user()->name }}</h4>
      <p class="text-muted small">{{ Auth::user()->email }}</p>
    </div>
    <hr class="bg-light"> <!-- Light horizontal line -->

    <!-- ✅ Link to open Change Password modal -->
    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
      <i class="bi bi-shield-lock-fill"></i> Change Password
    </a>

    <!-- ✅ Logout link -->
    <a href="{{ route('logout') }}" class="nav-link">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  </div>

  <!-- ================= Overlay ================= -->
  <!-- Dark background that shows when sidebar is active -->
  <div class="overlay"></div>

  <!-- ================= Main Page Content ================= -->
  <div class="content">
    <!-- ✅ Show success/error flash messages -->
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- ✅ Page title and Add Product button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">📦 Product Inventory</h2>
      <a href="{{ route('products.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add Product
      </a>
    </div>

    <!-- ================= Product Table ================= -->
    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th><th>Name</th><th>Price</th><th>Qty</th>
              <th>Category</th><th>Image</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- ✅ Loop through all products -->
            @foreach($products as $p)
              <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>Rs.{{ number_format($p->price,2) }}</td>
                <td>{{ $p->quantity }}</td>
                <td>{{ $p->category }}</td>
                <td>
                  <!-- ✅ Show product image if available, else show text -->
                  @if($p->image)
                    <img src="{{ asset('uploads/'.$p->image) }}" width="60" class="rounded img-thumbnail">
                  @else
                    <span class="text-muted">No Image</span>
                  @endif
                </td>
                <td>
                  <!-- ✅ Edit button -->
                  <a href="{{ route('products.edit',$p->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <!-- ✅ Delete button (with confirm popup via jQuery) -->
                  <a href="{{ route('products.delete',$p->id) }}" class="btn btn-sm btn-danger delete-btn">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ================= Change Password Modal ================= -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <!-- ✅ Form inside modal to update password -->
      <form method="POST" action="{{ route('password.update') }}" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Change Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- ✅ Current password input -->
          <div class="mb-3">
              <label>Current Password</label>
              <input type="password" class="form-control" name="current_password" required>
          </div>
          <!-- ✅ New password input -->
          <div class="mb-3">
              <label>New Password</label>
              <input type="password" class="form-control" name="new_password" required>
          </div>
          <!-- ✅ Confirm new password input -->
          <div class="mb-3">
              <label>Confirm New Password</label>
              <input type="password" class="form-control" name="new_password_confirmation" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Password</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ================= JavaScript Section ================= -->
  <script>
    $(function(){
      /* ✅ Toggle sidebar and overlay when hamburger OR overlay is clicked */
      $(".hamburger, .overlay").click(function(){
        $(".sidebar, .overlay").toggleClass("active");
      });

      /* ✅ Show confirm dialog when delete button is clicked */
      $(".delete-btn").click(function(e){
        if(!confirm("Are you sure you want to delete this product?")) e.preventDefault();
      });
    });
  </script>

</body>
</html>
