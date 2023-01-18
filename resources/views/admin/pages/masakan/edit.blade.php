@extends('admin.layout.app')
@section('title','Edit Masakan')
@section('content')
    <div class="card">
        <div class="container">
            <div class="card-header">
                <h2>Edit Masakan</h2>
            </div>
            <div class="card-body">
                <form action="/admin/masakan_edit_data/{{ $masakan->id_masakan }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama masakan">Nama Masakan</label>
                        <input type="text" class="form-control" value="{{ $masakan->nama_masakan }}" name="nama_masakan" placeholder="nama Masakan" id='nama' required>
                        @error('nama_masakan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" value="{{ $masakan->harga }}" name="harga" placeholder="Harga Masakan" id='harga' required>
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Type">Type</label>
                        <select name="type" class="form-control" id="Type" required>
                            <option value="">== Select Type ==</option>
                            <option value="makanan" {{ $masakan->type == 'makanan' ? 'selected' : ''}}>Makanan</option>
                            <option value="minuman" {{ $masakan->type == 'minuman' ? 'selected' : ''}}>Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Status masakan">Status Masakan</label>
                        <select name="status_masakan" class="form-control" id="Status masakan" required>
                            <option value="">== Select Status masakan ==</option>
                            <option value="tersedia" {{ $masakan->status_masakan == 'tersedia' ? 'selected' : ''}}>Tersedia</option>
                            <option value="habis" {{ $masakan->status_masakan == 'habus' ? 'selected' : ''}}>Habis</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image Masakan</label>
                        <input type="file" class="form-control" name="image" placeholder="image" id='image'>
                        @error('image')
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
