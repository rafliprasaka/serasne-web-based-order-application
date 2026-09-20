@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Categories</h3>
    <hr/>
    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Add New Category</a>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            List of Category
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-bordered table-striped" id="list-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td class="d-flex ">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm mx-1">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
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
