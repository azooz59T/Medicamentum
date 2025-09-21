<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        <div>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @else
                <span class="me-3">Hello, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Logout</button>
                </form>
            @endguest
        </div>
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
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <button onclick="addToCart({{ $product->id }})" class="btn btn-primary" id="btn-{{ $product->id }}">
                                <i class="fas fa-cart-plus me-1"></i>Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
            <a href="{{ route('cart.index') }}" class="group block p-2 rounded-lg hover:bg-gray-100 ms-3 position-relative">
                @svg('bxs-cart-alt', 'w-6 h-6 text-gray-900 group-hover:text-blue-500')
                <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                      style="{{ session()->has('cart') && array_sum(session('cart', [])) > 0 ? '' : 'display: none;' }}">
                    {{ session()->has('cart') ? array_sum(session('cart', [])) : 0 }}
                </span>
            </a>
        </div>
    </div>

    <script>
        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function addToCart(productId) {
            const button = document.getElementById(`btn-${productId}`);
            const originalText = button.innerHTML;
            
            // Show loading state
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success popup
                    const popup = document.getElementById('successPopup');
                    popup.style.display = 'block';
                    
                    // Update cart badge
                    updateCartBadge(data.cartCount);
                    
                    // Auto-hide popup after 2 seconds
                    setTimeout(function() {
                        popup.style.display = 'none';
                    }, 2000);
                } else {
                    alert('Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart');
            })
            .finally(() => {
                // Restore button
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        // Display product quantity in cart
        function updateCartBadge(count) {
            const badge = document.getElementById('cartBadge');
            
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    </script>
</body>
</html>