@extends('customer.layouts.customer')

@section('content')
    <h3 class="fw-bold py-3">CART</h3>

    @if ($cart->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table" style="font-size:12px">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->product->price }}</td>
                    <td>
                        <form class="d-inline" id="update-cart-{{ $item->id }}" action="{{ route('cart.update', ['cart' => $item->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-primary btn-sm" onclick="updateCart('{{ $item->id }}', 'decrement')"><i class="fa fa-minus"></i></button>
                            <input type="text" name="quantity" value="{{ $item->quantity }}" class="form-control d-inline w-25 text-center" style="display: inline-block;" readonly>
                            <button type="button" class="btn btn-primary btn-sm" onclick="updateCart('{{ $item->id }}', 'increment')"><i class="fa fa-plus"></i></button>
                        </form>
                    </td>
                    <td><span>Rp<span id="total-price-{{ $item->id }}">{{ $item->product->price * $item->quantity }}</span></span></td>
                    <td>
                        <form id="remove-cart-{{ $item->id }}" action="{{ route('cart.destroy', ['cart' => $item->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeCartItem('{{ $item->id }}')"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-2">
            <a href="{{ route('order.place', request()->route('table')) }}" class="btn btn-success w-100">Place Order</a>
        </div>
    @endif

    <script>
        function updateCart(cartId, action) {
            let form = document.getElementById('update-cart-' + cartId);
            let input = form.querySelector('input[name="quantity"]');
            let currentValue = parseInt(input.value);

            if (action === 'increment') {
                input.value = currentValue + 1;
            } else if (action === 'decrement' && currentValue > 1) {
                input.value = currentValue - 1;
            }

            // Submit the form via AJAX
            let formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                console.log('Cart updated successfully:', data);
                // Update the total price in the UI
                let totalPriceElement = document.getElementById('total-price-' + cartId);
                totalPriceElement.textContent = data.total_price;

                window.location.reload()
            }).catch(error => {
                console.error('There was an error updating the cart:', error);
                // Handle errors or notify user
            });
        }

        function removeCartItem(cartId) {
            let form = document.getElementById('remove-cart-' + cartId);

            // Submit the form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                console.log('Cart item removed successfully:', data);
                window.location.reload()
            }).catch(error => {
                console.error('There was an error removing the cart item:', error);
                // Handle errors or notify user
            });
        }
    </script>
@endsection
