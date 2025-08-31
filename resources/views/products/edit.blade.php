<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Ensures correct character encoding -->
    <title>Edit Product</title>

    <!-- ✅ Bootstrap CSS for layout, forms, buttons, etc. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ jQuery (if needed for extra JS functionality in future) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light"> <!-- Light background for better UI -->

<div class="container mt-5"> <!-- Bootstrap container with top margin -->
    <div class="card shadow-lg"> <!-- Card for nice box UI with shadow -->
        <div class="card-header bg-primary text-white"> <!-- Card header with blue background -->
            <h3>Edit Product</h3>
        </div>
        <div class="card-body"> <!-- Card body containing the form -->

            <!-- ✅ Form for updating product -->
            <!-- method="POST" ensures data is sent securely -->
            <!-- action="{{ route('products.update', $product->id) }}" sends form to update route -->
            <!-- enctype="multipart/form-data" is required to upload files (images) -->
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf <!-- CSRF token for Laravel security -->

                <!-- Product Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <!-- Pre-filled value from database -->
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                </div>

                <!-- Product Price -->
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <!-- step="0.01" allows decimal values -->
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ $product->price }}">
                </div>

                <!-- Product Quantity -->
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}">
                </div>

                <!-- Product Category -->
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-control" name="category" value="{{ $product->category }}">
                </div>

                <!-- Product Image Upload -->
                <div class="mb-3">
                    <label class="form-label">Image</label><br>
                    
                    <!-- ✅ Show old image if available -->
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}" width="100" class="mb-2 rounded">
                    @endif

                    <!-- File input for new image -->
                    <input type="file" class="form-control" name="image">

                    <!-- Hidden field to store old image name (so it can be deleted if new one uploaded) -->
                    <input type="hidden" name="old_image" value="{{ $product->image }}">
                </div>

                <!-- Submit and Back buttons -->
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
