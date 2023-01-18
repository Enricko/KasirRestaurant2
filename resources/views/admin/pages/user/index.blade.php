@extends('admin.layout.app')
@section('title','User Tables')
@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">User Tables</h2>
        <a href="/admin/user_tambah" class="btn btn-primary" style="float:right;">Tambah +</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Level</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1
            @endphp
            @foreach ($user as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->level }}</td>
                    <td>
                        <a href="/admin/user_edit/{{ $row->id }}" class="btn btn-warning">Edit</a>
                        <a href="/admin/user_delete/{{ $row->id }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
