<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
        <!-- Add this near the top of your cart view -->
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-5">
        <h1>Shopping Cart</h1>
        
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary mb-4">
            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
        </a>

        @if(empty($cartItems))
            <div class="text-center py-5">
                <h3>Your cart is empty</h3>
                <p>Add some products to get started!</p>
            </div>
        @else
            <div class="row">
                @foreach($cartItems as $item)
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <h5>{{ $item['product']->name }}</h5>
                                        <p class="text-muted">${{ number_format($item['product']->price, 2) }} each</p>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="input-group" style="width: 150px;">
                                            <button class="btn btn-outline-secondary btn-sm" 
                                                    onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] }} - 1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control form-control-sm text-center" 
                                                   value="{{ $item['quantity'] }}" min="0"
                                                   onchange="updateQuantity({{ $item['product']->id }}, this.value)">
                                            <button class="btn btn-outline-secondary btn-sm" 
                                                    onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] }} + 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <span class="badge bg-primary">Qty: {{ $item['quantity'] }}</span>
                                    </div>
                                    
                                    <div class="col-md-3 text-end">
                                        <strong>${{ number_format($item['subtotal'], 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Total -->
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h4>Total:</h4>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h4><strong>${{ number_format($total, 2) }}</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-grid">
                        <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function updateQuantity(productId, newQuantity) {
            newQuantity = parseInt(newQuantity);
            
            if (isNaN(newQuantity) || newQuantity < 0) {
                newQuantity = 0;
            }

            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Just reload the page to show updated cart
                    location.reload();
                } else {
                    alert('Error updating cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    </script>
</body>
</html>