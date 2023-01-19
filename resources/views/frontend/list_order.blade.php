@extends('frontend.layout.app')
@section('title','Kasir Restaurant')
@section('content')
@php
    use App\Models\DetailPesanan;

    $no = 1;
@endphp
    <div class="container-fluid text-light">
        <h1 class="text-center m-5">List Order</h1>
        <div class="card" style="background-color:#515151 ">
            <div class="card-body mx-auto">
                @if ($pesanan->count() <= 0)
                    <h1>Tidak ada orderan</h1>
                    <div class="mx-4">
                        <a href="/start_order" class="btn btn-secondary {{ $meja->where('status_meja','kosong')->count() <= 0 ? 'disabled' : '' }}">Start New Order</a>
                        <a href="/list_order" class="btn btn-secondary">View List Order</a>
                    </div>
                    <h3 class="mt-5 text-light">Total meja yang tersedia : {{ $meja->where('status_meja','kosong')->count() }}</h3>
                @else
                    <table class="table table-bordered table-responsive table-dark" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Pesanan</th>
                                <th>No Meja</th>
                                <th>List Pesanan</th>
                                <th>Total Harga</th>
                                <th style="width: 150px">Tanggal Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->id_pesanan }}</td>
                                    <td>{{ $row->no_meja }}</td>
                                    <td>
                                        <div style="width: 50vw;max-height:300px;">
                                            <table class="table table-bordered table-responsive table-dark">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th>Keterangan Pesanan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                        $total = 0;
                                                    @endphp
                                                    @foreach (DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',$row->id_pesanan)->get() as $x)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $x->nama_masakan }}</td>
                                                            <td>Rp.{{ number_format($x->harga) }}</td>
                                                            <td>{{ number_format($x->qty) }}</td>
                                                            <td>Rp.{{ number_format($x->sub_total) }}</td>
                                                            <td>
                                                                <div class="position-relative" style="width: 150px">
                                                                    {{ $x->keterangan_pesanan }}
                                                                <{{ $x->keterangan_pesanan }}/div>
                                                            </td>
                                                            <td>{{ $x->status_detail_pesanan }}</td>
                                                        </tr>
                                                        @php
                                                            $total += $x->sub_total;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4" class="text-center">Subtotal</th>
                                                        <th colspan="3" class="text-center">Rp.{{ number_format($total) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </td>
                                    <td>Rp.{{ number_format($row->total_harga) }}</td>
                                    <td>{{ date('l, d-m-Y',strtotime($row->tgl_pesanan)) }}</td>
                                    <td>
                                        <a href="/order/{{ $row->id_pesanan }}" class="btn btn-warning">Edit</a>
                                        <form action="/order_batal/{{ $row->id_pesanan }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')" type="submit" name="batal" value="list_order">Batal</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

