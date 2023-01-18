<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\Masakan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $data['meja'] = Meja::get();
        return view('frontend.index',$data);
    }
    public function start_order()
    {
        if (Meja::where('status_meja','kosong')->get()->count() <= 0) {
            return redirect()->to("/")->with('delete','Tidak ada meja yang kosong!');
        }
        $meja = Meja::where('status_meja','kosong')->inRandomOrder()->first();
        Meja::where('no_meja',$meja->no_meja)->where('status_meja','kosong')->update(['status_meja' => 'penuh']);
        $data = [
            'tgl_pesanan' => now(),
            'id' => Auth::user()->id,
            'no_meja' => $meja->no_meja,
            'total_harga' => 0,
            'bayar' => 0,
            'kembali' => 0,
            'status_pesanan' => '0',
            'status_makanan_pesanan' => 'sedang diproses'
        ];
        $id_pesanan = Pesanan::create($data)->id;
        return redirect()->to("/order/$id_pesanan");
    }
    public function order($id_pesanan)
    {
        $data['masakan'] = Masakan::all();
        $data['makanan'] = Masakan::where('type','makanan')->get();
        $data['minuman'] = Masakan::where('type','minuman')->get();
        $data['detail_pesanan'] = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',$id_pesanan)->get();
        $data['pesanan'] = Pesanan::where('id_pesanan',$id_pesanan)->get();
        $data['id_pesanan'] = $id_pesanan;
        return view('frontend.order',$data);
    }
    public function select_menu()
    {
        if (request()->ajax()) {
            $masakan = Masakan::where('id_masakan',request()->id_masakan)->first();
            $detail_pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->get();
            $pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->where('detail_pesanans.id_masakan',request()->id_masakan)->first();
            $output = FrontendController::outputAjax(request()->id_masakan,request()->id_pesanan);

            return Response($output);
        }
    }
    public function add_pesanan()
    {
        if(request()->ajax()){
            $masakan = Masakan::where('id_masakan',request()->id_masakan)->first();
            $data = [
                'id_pesanan' => request()->id_pesanan,
                'id_masakan' => request()->id_masakan,
                'qty' => request()->qty,
                'sub_total' => request()->qty * $masakan->harga,
                'keterangan_pesanan' => request()->keterangan_pesanan,
                'status_detail_pesanan' => 'dimasak'
            ];
            if(DetailPesanan::where('id_masakan',request()->id_masakan)->where('id_pesanan',request()->id_pesanan)->first()){
                DetailPesanan::where('id_pesanan',request()->id_pesanan)->where('id_masakan',request()->id_masakan)->update($data);
            }else{
                DetailPesanan::insert($data);
            }
            $detail_pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->get();
            $pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->where('detail_pesanans.id_masakan',request()->id_masakan)->first();
            $output = FrontendController::outputAjax(request()->id_masakan,request()->id_pesanan);

            return Response($output);
        }
    }
    public function remove_pesanan()
    {
        if(request()->ajax()){
            DetailPesanan::where('id_detail',request()->id_detail)->delete();
            $detail_pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->get();
            $pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->where('detail_pesanans.id_masakan',request()->id_masakan)->first();
            $output = FrontendController::outputAjax(request()->id_masakan,request()->id_pesanan);

            return Response($output);
        }
    }
    public static function outputAjax($id_masakan,$id_pesanan)
    {
        $masakan = Masakan::where('id_masakan',request()->id_masakan)->first();
        $detail_pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->get();
        $pesanan = DetailPesanan::join('masakans','masakans.id_masakan','=','detail_pesanans.id_masakan')->where('id_pesanan',request()->id_pesanan)->where('detail_pesanans.id_masakan',request()->id_masakan)->first();
        $output = "";
        $no = 1;
        $total = 0;
        if (!$pesanan) {
            $output .= "
                <div class='row mx-2'>
                    <div class='mx-auto text-center'>
                        <img src='".asset('image/masakan/'.$masakan->image_masakan)."' style='width:80px;height:80px;margin-bottom:5px;'>
                        <h4>".$masakan->nama_masakan."</h4>
                        <p>Rp.".number_format($masakan->harga,0,'.',',')."</p>
                    </div>
                    <input type='number' class='form-control' placeholder='qty' name='qty' id='qty-masakan' maxlength='5' required oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); return qty_masakan(value,".$masakan->harga.");'>
                    <input type='text' class='form-control mt-2' placeholder='Keterangan' name='keterangan_pesanan' id='keterangan_pesanan'>
                    <h5 class='mt-1 float-right'>Subtotal : <span id='subtotal-masakan'>Rp.0</span></h5>
                    <div class='col-12'>
                        <button class='btn btn-secondary float-right' onclick='return add_pesanan($masakan->id_masakan)'>Pesan</button>
                    </div>
                </div>
                <table class='table table-bordered table-dark mt-3'>
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
                    <tbody style='width: 100%; height: 100px; overflow-y: scroll;'>";
                    foreach($detail_pesanan as $row){
                        $output .="
                            <tr>
                                <td>".$no++."</td>
                                <td>".$row->nama_masakan."</td>
                                <td>Rp.".number_format($row->harga)."</td>
                                <td>".number_format($row->qty)."</td>
                                <td>Rp.".number_format($row->sub_total)."</td>
                                <td>
                                    <button class='btn btn-warning' onclick='return select_menu($row->id_masakan)'>Edit</a>
                                    <button class='btn btn-danger' onclick='return remove_pesanan($row->id_detail,$row->id_masakan)'>Delete</a>
                                </td>
                            </tr>";
                        $total += $row->sub_total;
                    }
                    $output .="
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan='4' class='text-center'>Subtotal</th>
                            <th colspan='2' class='text-center'>Rp.".number_format($total)."</th>
                        </tr>
                    </tfoot>
                </table>
            ";
        }else{
            $output .= "
                <div class='row mx-2'>
                    <div class='mx-auto text-center'>
                        <img src='".asset('image/masakan/'.$masakan->image_masakan)."' style='width:80px;height:80px;margin-bottom:5px;'>
                        <h4>".$masakan->nama_masakan."</h4>
                        <p>Rp.".number_format($masakan->harga,0,'.',',')."</p>
                    </div>
                    <input type='number' class='form-control' placeholder='qty' name='qty' id='qty-masakan' maxlength='5' required oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); return qty_masakan(value,".$masakan->harga.");'>
                    <input type='text' class='form-control mt-2' placeholder='Keterangan' name='keterangan_pesanan' id='keterangan_pesanan'>
                    <h5 class='mt-1 float-right'>Subtotal : <span id='subtotal-masakan'>Rp.0</span></h5>
                    <div class='col-12'>
                        <button class='btn btn-warning float-right' onclick='return add_pesanan($masakan->id_masakan)'>Edit</button>
                    </div>
                </div>
                <table class='table table-bordered table-dark mt-3'>
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
                    <tbody style='width: 100%; height: 100px; overflow-y: scroll;'>";
                    foreach($detail_pesanan as $row){
                        $output .="
                            <tr>
                                <td>".$no++."</td>
                                <td>".$row->nama_masakan."</td>
                                <td>Rp.".number_format($row->harga)."</td>
                                <td>".number_format($row->qty)."</td>
                                <td>Rp.".number_format($row->sub_total)."</td>
                                <td>
                                    <button class='btn btn-warning' onclick='return select_menu($row->id_masakan)'>Edit</a>
                                    <button class='btn btn-danger' onclick='return remove_pesanan($row->id_detail,$row->id_masakan)'>Delete</a>
                                </td>
                            </tr>";
                        $total += $row->sub_total;
                    }
                    $output .="
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan='4' class='text-center'>Subtotal</th>
                            <th colspan='2' class='text-center'>Rp.".number_format($total)."</th>
                        </tr>
                    </tfoot>
                </table>
            ";
        }

        return $output;
    }
}
