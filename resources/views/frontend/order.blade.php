@extends('frontend.layout.app')
@section('title','Kasir Restaurant')
@section('content')
<div class="container-fluid">
    <div class="card mt-5" style="background-color:#414141;height:100%;box-shadow:5px 5px 5px 5px black">
        <div class="card-body">
            <div class="row">
                <div class="col-4 col-sm-5 col-md-6 col-lg-7 col-xl-8">
                    <div class="d-flex justify-content-center mb-3">
                        <button onclick="return makanan()" class="btn btn-secondary makanan mx-1 active">Makanan</button>
                        <button onclick="return minuman()" class="btn btn-secondary minuman mx-1">Minuman</button>
                    </div>
                    <div class="search-makanan">
                        <div class="row" style="width: 100%; height: 450px; overflow-y: scroll;">
                            @foreach ($makanan as $makan)
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button class="btn card menu" name="menu" value="{{ $makan->id_masakan }}" type="submit" style="background-color:#717171;width:100%;height:280px;" onclick="return select_menu({{ $makan->id_masakan }})">
                                        <div class="mx-auto my-2">
                                            <img src="{{ asset('image/masakan').'/'.$makan->image_masakan }}" alt="" style="width:130px;height:140px;">
                                        </div>
                                        <div class="card-body" style="background-color:#656565;width:100%;">
                                            <h5 class="text-light" style="font-weight: 500">{{ $makan->nama_masakan }}</h5>
                                            <p class="text-light">Rp.{{ number_format($makan->harga) }}</p>
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="search-minuman d-none">
                        @if ($minuman->count() <= 0)
                            <div class="d-flex justify-content-center">
                                <h1 class="text-white">Minuman Lagi Kosong!!!</h1>
                            </div>
                        @else
                            @foreach ($minuman as $minum)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <button class="btn card menu" name="menu" value="{{ $minum->id_masakan }}" type="submit" style="background-color:#717171;width:100%;height:280px;" form="select_menu">
                                        <div class="mx-auto my-2">
                                            <img src="{{ asset('image/masakan').'/'.$minum->image_masakan }}" alt="" style="width:130px;height:140px;">
                                        </div>
                                        <div class="card-body" style="background-color:#656565;width:100%;">
                                            <h5 class="text-light" style="font-weight: 500">{{ $minum->nama_masakan }}</h5>
                                            <p class="text-light">Rp.{{ number_format($minum->harga) }}</p>
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-8 col-sm-7 col-md-6 col-lg-5 col-xl-4" style="border-left:2px solid black">
                    <div class="card" style="background-color:#515151;width: 100%; height: 510px; overflow-y: scroll;">
                        <div class="card-body">
                            <div class="select-masakan text-light">
                                <table class="table table-bordered table-dark">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody style="width: 100%; height: 100px; overflow-y: scroll;">
                                        @php
                                            $no = 1;
                                            $total = 0;
                                        @endphp
                                        @foreach ($detail_pesanan as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->nama_masakan }}</td>
                                                <td>Rp.{{ number_format($row->harga) }}</td>
                                                <td>{{ number_format($row->qty) }}</td>
                                                <td>Rp.{{ number_format($row->sub_total) }}</td>
                                                <td>
                                                    <button class="btn btn-warning" onclick="return select_menu({{ $row->id_masakan }})">Edit</a>
                                                    <button class="btn btn-danger" onclick="return remove_pesanan({{ $row->id_detail}},{{$row->id_masakan}})">Delete</a>
                                                </td>
                                            </tr>
                                            @php
                                                $total += $row->sub_total;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-center">Subtotal</th>
                                            <th colspan="2" class="text-center">Rp.{{ number_format($total) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function makanan(){
        document.querySelector('.search-makanan').classList.remove('d-none');
        document.querySelector('.search-minuman').classList.add('d-none');
        document.querySelector('.makanan').classList.add('active');
        document.querySelector('.minuman').classList.remove('active');
    }
    function minuman(){
        document.querySelector('.search-minuman').classList.remove('d-none');
        document.querySelector('.search-makanan').classList.add('d-none');
        document.querySelector('.makanan').classList.remove('active');
        document.querySelector('.minuman').classList.add('active');
    }

    function select_menu(id){
        $.ajax({
            type : 'get',
            url : '/select_menu',
            header:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                'id_masakan': id,
                'id_pesanan': {{ $id_pesanan }}
            },
            success:function(data){
                $('.select-masakan').html(data);
            }
        });
    }
    function qty_masakan(value,harga) {
        $total = value * harga;
        $format = $total.toLocaleString();
        $('#subtotal-masakan').text('Rp.' + $format);
    }
    function add_pesanan(id_masakan){
        $qty = document.getElementById("qty-masakan").value;
        $keterangan = document.getElementById("keterangan_pesanan").value;
        $.ajax({
            type : 'post',
            url : '/add_pesanan',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                'qty': $qty,
                'id_masakan': id_masakan,
                'keterangan_pesanan': $keterangan,
                'id_pesanan': {{ $id_pesanan }}
            },
            success:function(data){
                $('.select-masakan').html(data);
            },
        });
    }
    function remove_pesanan(id_detail,id_masakan) {
        $.ajax({
            type : 'get',
            url : '/remove_pesanan',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                'id_detail': id_detail,
                'id_masakan': id_masakan,
                'id_pesanan': {{ $id_pesanan }}
            },
            success:function(data){
                $('.select-masakan').html(data);
            }
        });
    }
</script>
@endsection
