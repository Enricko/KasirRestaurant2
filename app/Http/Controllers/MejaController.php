<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;

class MejaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['sidebar'] = 'meja';
        $data['meja'] = Meja::all();
        return view('admin.pages.meja.index',$data);
    }
    public function tambah()
    {
        $no = 1;
        for($i = 1;$i <= 100 ;$i++){
            $meja = Meja::where('no_meja',$i)->first();
            if($meja === null){
                $no = $i;
                break;
            }
        }
        $data = [
            'no_meja' => $no,
            'status_meja' => 'kosong'
        ];
        Meja::insert($data);
        return redirect()->back()->with('success','Data meja telah di tambahkan');
    }
    public function delete($no_meja)
    {
        Meja::where('no_meja',$no_meja)->delete();
        return redirect()->back()->with('delete','Data meja telah di hapus');
    }
    public function status_meja($no_meja){
        $status = request()->status_meja;

        if($status == 'kosong'){
            $status = 'penuh';
        }else{
            $status = 'kosong';
        }
        $data = [
            'status_meja' => $status
        ];
        Meja::where('no_meja',$no_meja)->update($data);
        return redirect()->to('/admin/meja')->with('update',"Status meja telah di ubah menjadi ".$status);

    }
}
