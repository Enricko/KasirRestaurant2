@extends('admin.layout.app')
@section('title','Edit User')
@section('content')
    <div class="card">
        <div class="container">
            <div class="card-header">
                <h2>Edit User </h2>
            </div>
            <div class="card-body">
                <form action="/admin/user_edit_data/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" name="name" placeholder="Name" id='name' required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select name="level" class="form-control" id="level" required>
                            <option value="">== Select Level ==</option>
                            <option value="waiter" {{ $user->level == 'waiter' ? 'selected' : ''}}>Waiter</option>
                            <option value="kasir" {{ $user->level == 'kasir' ? 'selected' : ''}}>Kasir</option>
                            <option value="admin" {{ $user->level == 'admin' ? 'selected' : ''}}>Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" name="email" placeholder="email" id='email' required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="password" id='password' required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password Confirm</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="password" id='password' required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
