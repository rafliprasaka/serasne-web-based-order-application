@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="pt-4">Add Product</h3>
    <hr>
    <div class="card">
        <div class="card-header">
            Form Product
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($product))
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
            @else
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Choose Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="{{ old('product_name', $product->product_name ?? '') }}" >
                    </div>
                    <div class="form-group mb-3">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price', $product->price ?? '') }}" >
                    </div>
                    <div class="form-group mb-3">
                        <label for="product_image">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control">
                        @if (isset($product) && $product->product_image)
                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="Product Image" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
