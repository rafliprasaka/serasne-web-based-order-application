@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Add Category</h3>
    <hr/>
    <div class="card">
        <div class="card-header">
            Form Category
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

            @if (isset($category))
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @method('PUT')
            @else
                <form action="{{ route('categories.store') }}" method="POST">
            @endif
                @csrf

                <div class="form-group mb-3">
                    <label for="">Categroy Name</label>
                    <input type="text" name="category_name" class="form-control" placeholder="Category Name" value="{{ old('category_name', $category->category_name ?? '') }}"/>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
