<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masakan;
class MasakanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data['sidebar'] = 'masakan';
        $data['masakan'] = Masakan::all();
        return view('admin.pages.masakan.index',$data);
    }
    public function tambah(){
        $data['sidebar'] = 'masakan';
        return view('admin.pages.masakan.tambah',$data);
    }
    public function tambah_data(){
        request()->validate([
            'nama_masakan' => ['required', 'string', 'max:255'],
        ]);
        $file = request()->image;

        $file_name = time().str_replace('.php','',$file->getClientOriginalName());

        $path_upload = 'image/masakan';

        $file->move($path_upload,$file_name);

        $data = [
            'nama_masakan' => request()->nama_masakan,
            'harga' => request()->harga,
            'type' => request()->type,
            'status_masakan' => request()->status_masakan,
            'image_masakan' => $file_name,
        ];

        Masakan::insert($data);

        return redirect()->to('/admin/masakan')->with('success','Data masakan telah di tambahkan');
    }
    public function edit($id_masakan){
        $data['sidebar'] = 'masakan';
        $data['masakan'] = Masakan::where('id_masakan',$id_masakan)->first();
        return view('admin.pages.masakan.edit',$data);
    }
    public function edit_data($id_masakan){
        request()->validate([
            'nama_masakan' => ['required', 'string', 'max:255'],
        ]);
        $masakan = Masakan::where('id_masakan',$id_masakan)->first();
        $file = request()->image;
        $old_image = $masakan->image_masakan;
        if($file != NULL){
            $file_name = time().str_replace('.php','',$file->getClientOriginalName());

            $path_upload = 'image/masakan';

            $file->move($path_upload,$file_name);
            $tmp = public_path('image/masakan/'.$old_image);
            if(file_exists($tmp)){
                unlink($tmp);
            }
        }else{
            $file_name = $old_image;
        }

        $data = [
            'nama_masakan' => request()->nama_masakan,
            'harga' => request()->harga,
            'type' => request()->type,
            'status_masakan' => request()->status_masakan,
            'image_masakan' => $file_name,
        ];
        Masakan::where('id_masakan',$id_masakan)->update($data);
        return redirect()->to('/admin/masakan')->with('update','Data masakan telah di ubah');
    }
    public function delete($id){
        $masakan = Masakan::where('id_masakan',$id)->first();
        $tmp = public_path('image/masakan/'.$masakan->image_masakan);
        if(file_exists($tmp)){
            unlink($tmp);
        }
        Masakan::where('id_masakan',$id)->delete();
        return redirect()->back()->with('delete','Data masakan telah di hapus');
    }

    public function persediaan($id_masakan){
        $status = request()->status_masakan;

        if($status == 'tersedia'){
            $status = 'habis';
        }else{
            $status = 'tersedia';
        }
        $data = [
            'status_masakan' => $status
        ];
        Masakan::where('id_masakan',$id_masakan)->update($data);
        return redirect()->to('/admin/masakan')->with('update',"Status masakan telah di ubah menjadi ".$status);

    }
}
