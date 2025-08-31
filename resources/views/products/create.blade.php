<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <!-- ✅ Bootstrap CSS for responsive UI components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- ✅ Light gray background for contrast -->
<body class="bg-light">

<div class="container mt-5">
    <!-- ✅ Card container for the form -->
    <div class="card shadow-lg">
        <!-- ✅ Card header with green background -->
        <div class="card-header bg-success text-white">
            <h3>Add Product</h3>
        </div>

        <div class="card-body">
            <!-- 
                ✅ Product Create Form
                - method="POST": sends data to the server
                - action="{{ route('products.store') }}": Laravel route to ProductController@store
                - enctype="multipart/form-data": allows image/file uploads
            -->
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                <!-- ✅ CSRF token for security against cross-site request forgery -->
                @csrf

                <!-- ✅ Product Name Field -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <!-- Text input for product name -->
                    <input type="text" class="form-control" name="name" placeholder="Enter product name">
                </div>

                <!-- ✅ Product Price Field -->
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <!-- Number input with step for decimals -->
                    <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price">
                </div>

                <!-- ✅ Product Quantity Field -->
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <!-- Number input for product quantity -->
                    <input type="number" class="form-control" name="quantity" placeholder="Enter quantity">
                </div>

                <!-- ✅ Product Category Field -->
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <!-- Text input for category name -->
                    <input type="text" class="form-control" name="category" placeholder="Enter category">
                </div>

                <!-- ✅ Product Image Upload Field -->
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <!-- File input for uploading product image -->
                    <input type="file" class="form-control" name="image">
                </div>

                <!-- ✅ Submit and Back Buttons -->
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
