@extends('admin.layout.app')
@section('title','Meja Tables')
@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Meja Tables</h2>
        <a href="/admin/meja_tambah" class="btn btn-primary" style="float:right;">Tambah +</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="myTable" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>No Meja</th>
          <th>Status Meja</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1
            @endphp
            @foreach ($meja as $row)
                <tr>
                    <td>{{ $row->no_meja }}</td>
                    <td>
                        <form action="/admin/status_meja/{{ $row->no_meja }}" method="POST">
                            @csrf
                            <button class="btn btn-{{ $row->status_meja == 'kosong' ? 'success' : 'danger' }}" type='submit' value="{{ $row->status_meja }}" name="status_meja">{{ $row->status_meja }}</button>
                        </form>
                    </td>
                    <td>
                        <a href="/admin/meja_delete/{{ $row->no_meja }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
