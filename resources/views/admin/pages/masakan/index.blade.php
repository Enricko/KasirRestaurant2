@extends('admin.layout.app')
@section('title','User Tables')
@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Masakan Tables</h2>
        <a href="/admin/masakan_tambah" class="btn btn-primary" style="float:right;">Tambah +</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No</th>
          <th>Image</th>
          <th>Nama</th>
          <th>Type</th>
          <th>Harga</th>
          <th>Status Masakan</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1
            @endphp
            @foreach ($masakan as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><img src="{{ asset('image/masakan').'/'.$row->image_masakan }}" alt="" width="150px"></td>
                    <td>{{ $row->nama_masakan }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->harga }}</td>
                    <td>
                        <form action="/admin/persedian_masakan/{{ $row->id_masakan }}" method="POST">
                            @csrf
                            <button class="btn btn-{{ $row->status_masakan == 'tersedia' ? 'success' : 'danger' }}" type='submit' value="{{ $row->status_masakan }}" name="status_masakan">{{ $row->status_masakan }}</button>
                        </form>
                    </td>
                    <td>
                        <a href="/admin/masakan_edit/{{ $row->id_masakan }}" class="btn btn-warning">Edit</a>
                        <a href="/admin/masakan_delete/{{ $row->id_masakan }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
