@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Transaction</h3>
    <hr/>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            List of Transaction
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="list-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>DATE</th>
                        <th>ID INVOICE</th>
                        <th>TABLE</th>
                        <th>SUB TOTAL</th>
                        <th>PPN</th>
                        <th>TOTAL AMOUNT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d/m/Y', strtotime($transaction->created_at)) }}</td>
                            <td>{{ Str::upper($transaction->invoice_id) }}</td>
                            <td>{{ $transaction->table->table_name }}</td>
                            <td><span class="float-start">Rp </span> <span class="float-end">{{ number_format($transaction->sub_total,0,',','.') }}</span></td>
                            <td><span class="float-start">Rp </span> <span class="float-end">{{ number_format($transaction->ppn,0,',','.') }}</span></td>
                            <td><span class="float-start">Rp </span> <span class="float-end">{{ number_format($transaction->total_amount,0,',','.') }}</span></td>
                            <td>{{ $transaction->status }}</td>
                            <td><a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm w-100">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
