<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Success Popup -->
    <div id="successPopup" class="position-fixed top-0 start-50 translate-middle-x mt-3" 
         style="z-index: 9999; display: none;">
        <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Success!</strong> Product added to cart.
        </div>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4">Our Products</h1>
        
        <!-- Simple Search and Sort -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
                    <!-- Search Bar -->
                    <div class="flex-grow-1">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search products by name..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </div>
                    
                    <!-- Price Sort Button -->
                    <div>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>
                        </select>
                    </div>
                    
                    <!-- Clear Button (only show if there are filters) -->
                    @if(request('search') || request('sort'))
                        <div>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        
        <div class="row">
            @if (count($products) == 0)
                <p class="text-red-700 text-xl text-center"> No Products Found </p>
            @endif
            @foreach ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <button onclick="addToCart('{{ $product->name }}')" class="btn btn-primary">
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script>
        function addToCart(productName) {
            // Show the success popup
            const popup = document.getElementById('successPopup');
            popup.style.display = 'block';
            
            // Auto-hide after 2 seconds
            setTimeout(function() {
                popup.style.display = 'none';
            }, 2000);
            
            // Optional: Add your actual add to cart logic here
            // For example, make an AJAX request to your backend
            console.log('Product added to cart: ' + productName);
        }
    </script>
</body>
</html>