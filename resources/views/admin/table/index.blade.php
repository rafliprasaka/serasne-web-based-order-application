@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Tables</h3>
    <hr/>
    @if (auth()->user()->role == 'admin')
    <a href="{{ route('tables.create') }}" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Add New Tables</a>
    @endif
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            List of Table
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
                        <th>Table Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $table->table_name }}</td>
                        <td>{{ $table->status }}</td>
                        <td class="d-flex ">
                            @if (auth()->user()->role == 'admin')
                            <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-info btn-sm mx-1">Edit</a>
                            <form action="{{ route('tables.destroy', $table->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this table?')">Delete</button>
                            </form>
                            @endif
                            <a href="{{ route('tables.qr-code', $table->id)}}" class="btn btn-warning btn-sm mx-1" target="_blank">Generate QR</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
