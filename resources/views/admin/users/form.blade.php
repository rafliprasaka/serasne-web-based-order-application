@extends('admin.layouts.admin')

@section('content')
<div class="continer-fluid">
    <h3 class="pt-4">{{ isset($user) ? 'Edit User' : 'Add User' }}</h3>
    <hr/>
    <div class="card">
        <div class="card-header">
            User Form
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

            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $user->name ?? '') }}"/>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $user->email ?? '') }}"/>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"/>
                </div>
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="admin" value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="admin">
                                Admin
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="cashier" value="cashier" {{ old('role', $user->role ?? '') == 'cashier' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cashier">
                                Cashier
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
