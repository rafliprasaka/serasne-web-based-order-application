@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Products</h3>
    <hr/>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Add New Product</a>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            List of Product
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="list-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Product</th>
                        <th>Price</th>
                        <th>Product Image</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>Rp {{ number_format($product->price,0,',','.') }}</td>
                            <td>
                                @if ($product->product_image)
                                    <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
