@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">Add Table</h3>
    <hr/>
    <div class="card">
        <div class="card-header">
            Form Table
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

            @if (isset($table))
                <form action="{{ route('tables.update', $table->id) }}" method="POST">
                    @method('PUT')
            @else
                <form action="{{ route('tables.store') }}" method="POST">
            @endif
                @csrf

                <div class="form-group mb-3">
                    <label for="">Table Name</label>
                    <input type="text" name="table_name" class="form-control" placeholder="Table Name" value="{{ old('table_name', $table->table_name ?? '') }}"/>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
