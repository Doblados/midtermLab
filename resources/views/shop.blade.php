<!DOCTYPE html>
<html lang="en" style="background-color: #E5C9D7;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/products/irasshai.jpg') }}">
    <title>Irasshaimase</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #productImage {
            max-width: 80%;
            max-height: 300px;
        }

        .modal-body {
            text-align: center;
        }

        .card-img-top {
            height: 200px;
            width: 100%;
        }

        .content
        {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .content:hover
        {
            transform: scale(1.05);
        }

        .custom-modal-width {
            max-width: 30%;
        }

        .modal-footer {
            margin-left: auto;
            margin-right: auto;
        }

        .modal-header {
            text-align: center;
        }
    </style>
</head>
<body style="background-color: #E5C9D7 !important;">
    <div class="container my-5">
        <h1 class="text-center mb-4">Irasshaimase</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('add-product') }}" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Add Product
            </a>
        </div>

        <!-- Product List -->
        <div class="row">
            @foreach ($products as $product)
                <div class="content col-md-4 col-sm-6 mb-4">
                    <div class="card h-100" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#productModal"
                         onclick="showProductDetails('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}', '{{ asset('storage/' . $product->image) }}', '{{ $product->description }}')">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" style="width: 100%;" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('storage/products/noImg.png') }}" class="card-img-top" alt="No Image">
                        @endif
                        <div class="card-body" style="border-radius: 10px; text-align: center;">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Price: ₱{{ $product->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Product Details -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-modal-width modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="productImage" src="" class="img-fluid rounded" alt="Product Image">
                    </div>
                    <h4 id="productName" class="text-center"></h4>
                    <p id="productPrice" class="text-center"></p>
                    <p id="productDescription" class="mt-3"></p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('update-product', $product->id) }}" class="btn btn-primary" id="updateProductButton">Update</a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showProductDetails(id, name, price, imageUrl, description) {
            document.getElementById('productName').textContent = name;
            document.getElementById('productPrice').textContent = `Price: ₱${price}`;
            document.getElementById('productImage').src = imageUrl || `{{ asset('storage/products/noImg.png') }}`;
            document.getElementById('productDescription').textContent = description || 'No description available.';
        }
    </script>
</body>
</html>