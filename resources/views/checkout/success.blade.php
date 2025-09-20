<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            <h1 class="mt-3">Order Placed Successfully!</h1>
            <p class="lead">Thank you for your order, {{ $order->name }}!</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details - #{{ $order->id }}</h5>
                    </div>
                    <div class="card-body">
                        <h6>Customer Information:</h6>
                        <p>
                            <strong>Name:</strong> {{ $order->name }}<br>
                            <strong>Phone:</strong> {{ $order->phone }}<br>
                            <strong>Address:</strong> {{ $order->address }}
                        </p>

                        <h6>Items Ordered:</h6>
                        @foreach($order->cart_items as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                                <span>${{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                        @endforeach
                        
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total: </strong>
                            <strong>${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>