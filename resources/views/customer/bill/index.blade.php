@extends('customer.layouts.customer')

@section('content')
<h3 class="fw-bold py-3">BILL</h3>

@if ($bill->isEmpty())
    <p>Your bill is empty.</p>
@else
    <table class="table table-bordered table-striped" style="font-size:12px">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($bill as $item)
                @php
                    $itemTotal = $item->product->price * $item->quantity;
                    $total += $itemTotal;
                @endphp
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>
                        <span class="float-start">Rp</span>
                        <span class="float-end">{{ number_format($item->product->price, 0, ',', '.') }}</span>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <span class="float-start">Rp</span>
                        <span class="float-end">{{ number_format($itemTotal, 0, ',', '.') }}</span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" align="right" class="fw-bold">Total</td>
                <td>
                    <span class="float-start">Rp</span>
                    <span class="float-end">{{ number_format($total, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right" class="fw-bold">PPN (11%)</td>
                <td>
                    <span class="float-start">Rp</span>
                    <span class="float-end">{{ number_format($total * 0.11, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right" class="fw-bold">Total Pembayaran</td>
                <td>
                    <span class="float-start">Rp</span>
                    <span class="float-end">{{ number_format($total + ($total * 0.11), 0, ',', '.') }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="p-2">
        <a href="{{ route('bill.close', request()->route('table')) }}" class="btn btn-success w-100">Close Bill</a>
    </div>
@endif
@endsection
