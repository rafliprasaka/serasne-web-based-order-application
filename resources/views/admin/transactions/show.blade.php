@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Transaction Details</h3>
    <hr/>
    <div class="card col-6 mx-auto">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>INVOICE ID</th>
                    <td>{{ Str::upper($transaction->invoice_id) }}</td>
                </tr>
                <tr>
                    <th>TRANSACTION DATE</th>
                    <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                </tr>
                <tr>
                    <th>TABLE</th>
                    <td>{{ $transaction->table->table_name }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                            </tr>
                        @foreach ($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->product->product_name }}</td>
                                <td><span class="float-start">Rp</span><span class="float-end">{{ number_format($detail->price, 0, ',', '.') }}</span></td>
                                <td>{{ $detail->quantity }}</td>
                                <td><span class="float-start">Rp</span><span class="float-end">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</span></td>
                            </tr>
                        @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>SUB TOTAL</th>
                    <td><span class="float-start">Rp</span><span class="float-end">{{ number_format($transaction->sub_total, 0, ',', '.') }}</span></td>
                </tr>
                <tr>
                    <th>PPN</th>
                    <td><span class="float-start">Rp</span><span class="float-end">{{ number_format($transaction->ppn, 0, ',', '.') }}</span></td>
                </tr>
                <tr>
                    <th>TOTAL AMOUNT</th>
                    <td><span class="float-start">Rp</span><span class="float-end">{{ number_format($transaction->total_amount, 0, ',', '.') }}</span></td>
                </tr>
            </table>

            @if ($transaction->status == 'close-bill')
                <form action="{{ route('transactions.payment', $transaction->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button class="w-100 btn btn-success fw-bold">PROCEED PAYMENT</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
